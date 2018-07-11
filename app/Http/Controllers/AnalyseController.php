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
    public  function  index(){
        //Recuperation des id dans la table ea_analyse
        $sampleID = $this->getSingleAnalyseID('SampleType_ID');
        $techniqueID = $this->getSingleAnalyseID('Technique_ID');
        $moleculeID = $this->getSingleAnalyseID('Molecule_ID');


        //Recupere les valeurs dans les tables concernees
        $sample = Sample::whereIn('SampleType_ID', createArray($sampleID, 'SampleType_ID'))
                            ->get(['SampleType_ID', 'SampleType_Name']);
        $technique = Technique::whereIn('Technique_ID', createArray($techniqueID, 'Technique_ID'))
                            ->get(['Technique_ID', 'Technical_Name']);
        $molecule = Molecule::whereIn('Molecule_ID', createArray($moleculeID, 'Molecule_ID'))
                            ->get(['Molecule_ID', 'Molecule_Name']);

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

        if (Session::has('save-patientID-4') and $previousPath=='/research/biochemistry'){
            $patient = Session::get('save-patientID-4');
            Session::put('patientID', $patient);
        }

        //Creation de la requete
        $requestAnalyse = "SELECT a.Analyse_ID as Analyse_ID FROM ea_analyse a WHERE a.Patient_ID in ".createList(Session::get('patientID'));
        $requestPatient = "SELECT distinct a.Patient_ID as Patient_ID FROM ea_analyse a WHERE a.Patient_ID in ".createList(Session::get('patientID'));

        if(isset($params) && count($params)>0){
            foreach ($params as $item => $value){

                $list = createList($params[$item]);

                //Creation de la requete
                $requestAnalyse .= "AND ". $item ."_ID in ". $list;
                $requestPatient .= "AND ". $item ."_ID in ". $list;
            }

            //Execution des requetes
            $analyseID = DB::SELECT($requestAnalyse."
                         AND a.CID_ID in ".createList(Session::get('cidID')));
            $patientID = DB::SELECT($requestPatient."
                         AND a.CID_ID in ".createList(Session::get('cidID')));

            //Si il y a des resultats -> session
            //sinon message d'erreur et retour arriere avec les données
            if(count($patientID)){
                Session::put('patientID', createArray($patientID, 'Patient_ID'));
            }else{
                Session::flash('nothing',"No data found with your criteria");
                return redirect()->route('analyse')->withInput();
            }

            // ajout des id en session
            Session::put('analyseID', createArray($analyseID, 'Analyse_ID'));
            Session::put('patientID', createArray($patientID, 'Patient_ID'));

        }else{
            $analyseID = DB::SELECT($requestAnalyse."
                         AND a.CID_ID in ".createList(Session::get('cidID')));
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
