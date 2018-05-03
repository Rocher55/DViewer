<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cid;
use App\Cid_patient;
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
        $cid_id = Cid_patient::distinct()->whereIn('Patient_ID', Session::get('patientID'))->get(['CID_ID']);

        $cids = Cid::whereIn('CID_ID', $cid_id)->get();

        return view('Forms.cid',compact('cids'));
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

                    //Si il existe une partie apres le point alors
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
                    } else {
                        //sinon requete avec simple =
                        $req = " AND " . $param . " = " . $value;
                    }
                }
                //Concatenation des differents bouts de requete
                $paramReq .=  $req;
            }
        }

        //Si ma chaine deparametre est valide alors
        if(isset($paramReq) && $paramReq != null){

            //Creation de la liste des Patient_ID de l'etape precedente
            $patientID =  $this->createListOfPatient(Session::get('patientID'));


            //Execution de la requete avec les parametres
            $newPatientID = DB::Select('SELECT Patient_ID as Patient_ID 
                                        FROM patients
                                        WHERE Patient_ID in'.$patientID
                . $paramReq);

            //Ajout des resultats dans la sesion precedente
            Session::put('patientID', $newPatientID);
        }

        return redirect()->route('cid');
    }






}
