<?php

namespace App\Http\Controllers;


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
        $patient=Session::get('patientID');
        $list=null;

        //Creation d'une liste avec les id patient
        if(count($patient)) {
            $list = $this->createList($patient,'Patient_ID');
        }else{
            $list = $this->createList($patient, 'Patient_ID');
        }

        //Recuperation et cretion d'une liste des tous les CID_ID
        $cid_id = DB::Select('SELECT CID_ID as CID_ID FROM cid_patient WHERE Patient_ID in'.$list);
        $cid_final = $this->createList($cid_id, 'CID_ID');

        //Recuperation des infos sur les CID_ID
        $cids = DB::Select('SELECT CID_ID as CID_ID, CID_Name as CID_Name FROM cids WHERE CID_ID IN'. $cid_final);

        Session::put('cidID',$cid_final);

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
            $paramReq = "AND CID_ID IN ".$this->simpleCreateList($params);
        }

        //Creation de la liste des Patient_ID de l'etape precedente
        $patientID =  $this->createList(Session::get('patientID'),'Patient_ID');

        //Si ma chaine de parametres est valide alors
        if(isset($paramReq) && $paramReq != ""){
            //Execution de la requete avec les parametres
            $results_p = DB::Select('SELECT distinct Patient_ID as Patient_ID
                                        FROM cid_patient
                                        WHERE Patient_ID in'. $patientID . $paramReq);
            $results_c = $this->getCID($patientID,$paramReq);

            //Ajout des resultats dans les sesions
            Session::put('patientID', $results_p);
            Session::put('cidID', $results_c);
        } else {
            $results_c = $this->getCID($patientID,$paramReq="");
            Session::put('cidID', $results_c);
        }


        return redirect()->route('food');
    }


    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     *
     *
     * @param $data
     * @return string
     */
    public function createList($data, $column){
        $return=" (";
        foreach ($data as $item){
            $return .= $item->$column .", ";
        }
        $return = substr($return, 0, -2) .") ";

        return $return;
    }

    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     * directement à partir de la saisie
     *
     *
     * @param $data
     * @return string
     */
    public function simpleCreateList($data){
        $return=" (";
        foreach ($data as $item){
            $return .= $item .", ";
        }
        $return = substr($return, 0, -2) .") ";

        return $return;
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
