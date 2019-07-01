<?php

namespace App\Http\Controllers;

use App\Analyse;
use App\Molecule;
use App\Sample;
use App\Technique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class AnalyseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public  function  index(){
        womanPercentage();

        $previousPath = Session::get('previous');
        if (Session::has('save-patientID-4') and ($previousPath=='/research/select-gene' )) {
            $patient = Session::get('save-patientID-4');
            Session::put('patientID', $patient);
        }
        //Recuperation des id dans la table ea_analyse
        $sampleID = $this->getSingleAnalyseID('SampleType_ID');
        $techniqueID = $this->getSingleAnalyseID('Technique_ID');
        $moleculeID = $this->getSingleAnalyseID('Molecule_ID');


        //Recupere les valeurs dans les tables concernees
       /* $sample = Sample::whereIn('SampleType_ID', createArray($sampleID, 'SampleType_ID'))
                            ->get(['SampleType_ID', 'SampleType_Name']);
        */
        //les trois requetes suivantes sont identiques, mais déclinées pour molecules,sampletypes, et techniques. Elles recupèrent respectivement les samples, techniques et molecules
        //correspondants aux patients et aux critères séléctionnés pour biochem
        $sample=DB::select("select distinct sampletypes.SampleType_ID,sampletypes.SampleType_Name from sampletypes,ea_analyse,biochemistry
where biochemistry.Patient_ID=ea_analyse.Patient_ID
AND biochemistry.CID_ID=ea_analyse.CID_ID
AND ea_analyse.SampleType_ID=sampletypes.SampleType_ID
AND sampletypes.SampleType_ID in ".createList(createArray($sampleID,'SampleType_ID'))."
AND CONCAT(biochemistry.Nomenclature_ID,'-', biochemistry.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView')));

        /*$technique = Technique::whereIn('Technique_ID', createArray($techniqueID, 'Technique_ID'))
                            ->get(['Technique_ID', 'Technical_Name']);
        */
        $technique=DB::select("select distinct techniques.Technique_ID,techniques.Technical_Name from techniques,ea_analyse,biochemistry
where biochemistry.Patient_ID=ea_analyse.Patient_ID
AND biochemistry.CID_ID=ea_analyse.CID_ID
AND ea_analyse.Technique_ID=techniques.Technique_ID
AND techniques.Technique_ID in ".createList(createArray($techniqueID,'Technique_ID'))."
AND CONCAT(biochemistry.Nomenclature_ID,'-', biochemistry.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView')));

        /*$molecule = Molecule::whereIn('Molecule_ID', createArray($moleculeID, 'Molecule_ID'))
                            ->get(['Molecule_ID', 'Molecule_Name']);
        */
        $molecule=DB::select("select distinct molecules.Molecule_ID,molecules.Molecule_Name from molecules,ea_analyse,biochemistry
where biochemistry.Patient_ID=ea_analyse.Patient_ID
AND biochemistry.CID_ID=ea_analyse.CID_ID
AND ea_analyse.Molecule_ID=molecules.Molecule_ID
AND molecules.Molecule_ID in ".createList(createArray($moleculeID,'Molecule_ID'))."
AND CONCAT(biochemistry.Nomenclature_ID,'-', biochemistry.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView')));

        if(count($sample) && count($technique) && count($molecule)){
            return view('Forms.analyse', compact('molecule', 'sample', 'technique'));
        }else{
            return redirect()->route('result');
        }


    }



    /**
     * Traitement des donnees postees
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSelect(){
        $params = Input::except('_token');  //Recuperation de tous les Input sauf le token
        $analyseID = "";                    //Resultat de la requete d'analyse
        $previousPath = Session::get('previous');

        if (Session::has('save-patientID-4') and $previousPath=='/research/select-gene'){
            $patient = Session::get('save-patientID-4');
            Session::put('patientID', $patient);
        }

        //Creation de la requete
        $requestAnalyse = "SELECT ea_analyse.Analyse_ID as Analyse_ID FROM ea_analyse ,biochemistry,cid_patient 
                            WHERE ea_analyse.CID_ID=cid_patient.CID_ID
                            AND ea_analyse.Patient_ID=cid_patient.Patient_ID
                            AND biochemistry.CID_ID=cid_patient.CID_ID
                            AND biochemistry.Patient_ID=cid_patient.Patient_ID
                            AND CONCAT(biochemistry.Nomenclature_ID,'-', biochemistry.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView'))."
                            AND ea_analyse.Patient_ID in ".createList(Session::get('patientID'));
        //$requestPatient = "SELECT distinct a.Patient_ID as Patient_ID FROM ea_analyse a WHERE a.Patient_ID in ".createList(Session::get('patientID'));
        $requestPatient = "SELECT distinct ea_analyse.Patient_ID as Patient_ID FROM ea_analyse,biochemistry,cid_patient 
                            WHERE ea_analyse.CID_ID=cid_patient.CID_ID
                            AND ea_analyse.Patient_ID=cid_patient.Patient_ID
                            AND biochemistry.CID_ID=cid_patient.CID_ID
                            AND biochemistry.Patient_ID=cid_patient.Patient_ID
                            AND CONCAT(biochemistry.Nomenclature_ID,'-', biochemistry.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView'))."
                            AND ea_analyse.Patient_ID in ".createList(Session::get('patientID'));

        if(isset($params) && count($params)>0){
            foreach ($params as $item => $value){
                $list = createList($params[$item]);

                //Creation de la requete
                $requestAnalyse .= "AND ". $item ."_ID in ". $list;
                $requestPatient .= "AND ". $item ."_ID in ". $list;
            }

            //Execution des requetes
            $analyseID = DB::SELECT($requestAnalyse."
                         AND ea_analyse.CID_ID in ".createList(Session::get('cidID')));
            $patientID = DB::SELECT($requestPatient."
                         AND ea_analyse.CID_ID in ".createList(Session::get('cidID')));


            //Si il y a des resultats -> session
            //sinon message d'erreur et retour arriere avec les données
            if(!count($patientID)){
                Session::flash('nothing',"No data found with your criteria");
                return redirect()->route('analyse')->withInput();
            }


            // ajout des id en session
            Session::put('analyseID', createArray($analyseID, 'Analyse_ID'));
            Session::put('patientID', createArray($patientID, 'Patient_ID'));

        }else{
            $analyseID = DB::SELECT($requestAnalyse."
                         AND ea_analyse.CID_ID in ".createList(Session::get('cidID')));
            Session::put('analyseID',createArray($analyseID, 'Analyse_ID'));
        }


        return redirect()->route('select-gene');
    }



    /**
     * @param $column   colonne dont on veut la liste des differentes valeurs
     * @return mixed    la liste
     */
    public function getSingleAnalyseID($column){

        $patientID = Session::get('patientID');
        $result = Analyse::whereIn('Patient_ID', $patientID)->distinct()->get([$column]);

        return $result;
    }
}
