<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{

    /**
     *  Recupere les patiens concernes par un centre et protocol
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Recupere les patients concernes par un centre et protocole
        $patient = Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->get(['Patient_ID']);

        Session::put('patientID', $patient);



        //Recuperation des sexes
        $sex = Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->get(['Sex']);

        $allSex = array();
        foreach($sex as $item){
            array_push($allSex, $item->Sex);
        }
        $uniqueSex = array_keys(array_flip($allSex));


        return view('Forms.patient', compact('uniqueSex'));
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
                    } else {
                        //sinon requete avec simple =
                        $req = " AND " . $param . " = " . $value;
                    }
                }
                //Concatenation des differents bouts de requete
                $paramReq .=  $req;
            }
        }

        //Si ma chaine de parametres est valide alors
        if(isset($paramReq) && $paramReq != ""){

            //Creation de la liste des Patient_ID de l'etape precedente
            $patientID =  $this->createListOfPatient(Session::get('patientID'));

            //Execution de la requete avec les parametres
            $newPatientID = DB::Select('SELECT Patient_ID as Patient_ID
                                        FROM patients
                                        WHERE Patient_ID in'. $patientID . $paramReq);


            //Ajout des resultats dans la sesion precedente
            Session::put('patientID', $newPatientID);
        }

        return redirect()->route('cid');
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete
     *
     *
     * @param $data
     * @return string
     */
    public function createListOfPatient($data){
        $return=" (";
        foreach ($data as $item){
            $return .= $item->Patient_ID .", ";
        }
        $return = substr($return, 0, -2) .") ";

       return $return;
    }


}




