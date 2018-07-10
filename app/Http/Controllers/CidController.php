<?php

namespace App\Http\Controllers;


use App\Cid;
use App\Cid_patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CidController extends Controller
{
    /**
     *  Recupere les cids qui concernent les patients
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Session::has('save-patientID-1')){
            $patient = Session::get('save-patientID-1');
        }else{
            $patient=Session::get('patientID');

            Session::put('save-patientID-2', Session::get('patientID'));
        }


        //Recuperation et cretion d'une liste des tous les CID_ID
        $cid_id = Cid_patient::whereIn('Patient_ID', $patient)
                                ->orderBy('CID_ID', 'ASC')
                                ->distinct()
                                ->get(['CID_ID']);

        //Recuperation des infos sur les CID_ID
        $cids = Cid::whereIn('CID_ID', $cid_id )->get(['CID_ID', 'CID_Name']);

        Session::put('cidID',createArray($cid_id, 'CID_ID'));

        return view('Forms.cid', compact('cids'));
    }



    /**
     * Traitement des donnees postees
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSelect()
    {
        //Recuperation de tous les Input sauf le token
        $params = Input::get('cid');
        $paramReq= "";

        //Si il existe des parametres alors
        if(isset($params)) {
            $paramReq = "AND CID_ID IN ".createList($params);
        }

        //Creation de la liste des Patient_ID de l'etape precedente
        $patientID =  createList(Session::get('patientID'));

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
