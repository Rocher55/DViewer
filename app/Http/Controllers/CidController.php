<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cid;
use App\Cid_patient;
use Illuminate\Support\Facades\DB;
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
            $list = $this->createListOfCID($patient,'Patient_ID');
        }else{
            $list = $this->createListOfCID($patient, 'Patient_ID');
        }


        //Recuperation et cretion d'une liste des tous les CID_ID
        $cid_id = DB::Select('SELECT CID_ID as CID_ID FROM cid_patient WHERE Patient_ID in'.$list);
        $cid_final = $this->createListOfCID($cid_id, 'CID_ID');

        //Recuperation des infos sur les CID_ID
        $cids = DB::Select('SELECT CID_ID as CID_ID, CID_Name as CID_Name FROM cids WHERE CID_ID IN'. $cid_final);

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
        $params = Input::except('_token');
        $paramReq= "";

        //Si il existe des parametres alors
        if(isset($params)) {

            //Pour chaque parametre
            foreach ($params as $param => $value) {
                $req = "";

                //Si la clef et valide ainsi que la valeur alors
                //Separer la chaine (clef) en fonction du "-" (marche pas avec ".")
                if (isset($param) && isset($value)){
                    $key = explode("-", $param);

                    //Si il existe une partie apres le - alors
                    //en fonction de sa valeur (from ou to) definir la chaine de requete
                    //correspondante
                    if (isset($key[1])) {
                        switch ($key[1]) {
                            case "from":
                                $req = " AND " . $key[0] . " >= " . $value;
                                break;
                            case "to":
                                $req = " AND " . $key[0] . " <= " . $value;
                                break;
                        }
                    }
                }
                //Concatenation des differents bouts de requete
                $paramReq .=  $req;
            }
        }
    }

/*

    SELECT * FROM food_diaries f, unite_mesure u, nomenclatures n
    WHERE f.Nomenclature_ID = n.Nomenclature_ID
    AND f.Unite_Mesure_ID = u.Unite_Mesure_ID
    AND( n.Nomenclature_ID =165 and  f.Valeur<=12 and f.Valeur >=1 and u.Unite_Mesure_ID = 34)

*/





    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     *
     *
     * @param $data
     * @return string
     */
    public function createListOfCID($data, $column){
        $return=" (";
        foreach ($data as $item){
            $return .= $item->$column .", ";
        }
        $return = substr($return, 0, -2) .") ";

        return $return;
    }



}
