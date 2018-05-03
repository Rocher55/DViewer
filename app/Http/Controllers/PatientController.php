<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    public function index()
    {
        //Recupere les patients concernes par un centre et protocole
        $patientId = Patient::whereIn('Protocol_ID' , Session::get('protocolID'))
                        ->whereIn('Center_ID' , Session::get('centerID'))
                        ->get(['Patient_ID']) ;

        //Ajout des id en session
        Session::put('patientID', $patientId);


        return view('Forms.patient');
    }




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

        if(isset($paramReq) && $paramReq != null){
            $patientID =  $this->createListOfPatient(Session::get('patientID'));

            $newPatientID = DB::Select('SELECT Patient_ID as Patient_ID 
                                        FROM patients
                                        WHERE Patient_ID in'.$patientID
                                       . $paramReq);

            Session::put('patientID', $newPatientID);
        }

        return redirect()->route('cid');
    }


    public function createListOfPatient($data){
        $return=" (";
        foreach ($data as $item){
            $return .= $item->Patient_ID .", ";
        }
        $return = substr($return, 0, -2) .") ";

        return $return;
    }


}




