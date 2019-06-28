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
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index(){

        //Recupere les patients concernes par un centre et protocole
        $patient = Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->get(['Patient_ID']);
        //dd(createList($patient,'Patient_ID'));

        $min= Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->min('age');
        $max = Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->max('age');

        Session::put('patientID', createArray($patient, 'Patient_ID'));
        Session::put('save-patientID-1', createArray($patient, 'Patient_ID'));


        //Recuperation des sexes
        $sex = Patient::whereIn('Protocol_ID', Session::get('protocolID'))
            ->whereIn('Center_ID', Session::get('centerID'))
            ->get(['Sex']);

        $allSex = array();
        foreach($sex as $item){
            array_push($allSex, $item->Sex);
        }
        $uniqueSex = array_keys(array_flip($allSex));
        womanPercentage();
        return view('Forms.patient', compact('uniqueSex', 'min', 'max'));
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
        $request = $this->createRequest($params);


        //Si ma chaine de parametres est valide alors
        if(isset($request) && $request != ""){

            //Creation de la liste des Patient_ID de l'etape precedente
            $patientID =  createList(Session::get('patientID'));

            //Execution de la requete avec les parametres
            $newPatientID = DB::Select('SELECT Patient_ID as Patient_ID
                                        FROM patients
                                        WHERE Patient_ID in'. $patientID . $request);


            if(count($newPatientID)){
                //Ajout des resultats dans la sesion precedente
                Session::put('patientID', createArray($newPatientID, 'Patient_ID'));
                Session::put('save-patientID-1', createArray($newPatientID, 'Patient_ID'));
            }else{
                Session::flash('nothing',"No data found with your criteria");
                return redirect()->route('patient')->withInput();
            }
        }

        return redirect()->route('cid');

    }


    public function createRequest($params){
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
                        //dd($req);
                    }
                }
                //Concatenation des differents bouts de requete
                $paramReq .=  $req;
            }
        }
        return $paramReq;
    }








}




