<?php

namespace App\Http\Controllers;


use App\Cid;
use App\Cid_patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CidController extends Controller{



    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     *  Recupere les cids qui concernent les patients
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        womanPercentage();
        Session::put('save-patientID-2', Session::get('save-patientID-1'));

        //Recuperation et creation d'une liste de tous les CID_ID
        /*$cid_id = Cid_patient::whereIn('Patient_ID', Session::get('patientID'))
                                ->orderBy('CID_ID', 'ASC')
                                ->distinct()
                                ->get(['CID_ID']);

        //Recuperation des infos sur les CID_ID
        $kids = Cid::whereIn('CID_ID', $cid_id )->get(['CID_ID', 'CID_Name']);
        */
        $cids= Cid::Select('cids.CID_ID','CID_Name')
            ->distinct()
            ->join('cid_patient','cids.CID_ID','=','cid_patient.CID_ID')
            ->whereIn('cid_patient.CID_ID',Session::get('patientID'))
            ->get();

        Session::put('cidID',createArray($cids, 'CID_ID'));
        return view('Forms.cid', compact('cids'));
    }



    /**
     * Traitement des donnees postees
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSelect(){
        $previousPath = Session::get('previous');

        if (Session::has('save-patientID-1') and ($previousPath==='/research/food' or $previousPath==='/research/biochemistry')){
            $patient = Session::get('save-patientID-1');
            Session::put('patientID', $patient);
        }
        //Creation de la liste des Patient_ID de l'etape precedente
        $patientID =  createList(Session::get('patientID'));

        //Recuperation de tous les Input sauf le token
        $params = Input::get('cid');
        $paramReq= "";

        //Si il existe des parametres alors
        if(isset($params)) {
            $paramReq = "AND CID_ID IN ".createList($params);
        }


        //Si ma chaine de parametres est valide alors
        if(isset($paramReq) && $paramReq != ""){
            //Execution de la requete avec les parametres
            $results_p = DB::Select('SELECT distinct Patient_ID as Patient_ID
                                        FROM cid_patient
                                        WHERE Patient_ID in'. $patientID . $paramReq);
            $results_c = $this->getCID($patientID,$paramReq);

            //Ajout des resultats dans les sesions
            Session::put('patientID', createArray($results_p, 'Patient_ID'));
            Session::put('save-patientID-2', createArray($results_p, 'Patient_ID'));
            Session::put('cidID', createArray($results_c, 'CID_ID'));

        } else {
            $results_c = $this->getCID($patientID,$paramReq="");
            Session::put('patientID',Session::get('save-patientID-1'));
            Session::put('cidID', createArray($results_c, 'CID_ID'));
        }

        return redirect()->route('food');
    }




    /**
     * Recupere les cid
     *
     * @param $patientID
     * @param $paramReq
     * @return mixed
     */
    public function getCID($patientID, $paramReq){
        $results = DB::Select('SELECT distinct CID_ID as CID_ID
                                        FROM cid_patient
                                        WHERE Patient_ID in'. $patientID . $paramReq);

        return $results;
    }

}
