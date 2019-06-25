<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class BiochemistryController extends Controller{


    /** Recuperation des données pour affichage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function  index(){
        womanPercentage();
        Session::forget('biochemistryToView');


        $previousPath = Session::get('previous');
        if (Session::has('save-patientID-3') and ($previousPath=='/research/analyse' or $previousPath=='/research/activities')){
            $patient = Session::get('save-patientID-3');
            Session::put('patientID', $patient);
        }
        Session::put('save-patientID-4', Session::get('save-patientID-3'));

        //cf. fonction
        $concerned = $this->getConcernedBIO();

        $family = $this->getUniqueFamily($concerned);
        asort($family);

        return view('Forms.biochemistry', compact('family','concerned'));
    }


    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postSelect(){
        $params = Input::except('_token');  //Recuperation de tous les Input sauf le token
        $request = "";                     //String de la requete
        $previousPath = Session::get('previous');

        if (Session::has('save-patientID-3') and $previousPath=='/research/analyse'){
            $patient = Session::get('save-patientID-3');
            Session::put('patientID', $patient);
        }

        //Si il existe des parametres alors
        if (isset($params)) {
            $seenID = array();                      //tableau permettant de savoir si une id a deja ete vue
            $end=false;                             //variable pour savoir si l'on peut faire la fin de la requete
            //(car sinon generation de la partie "patient" meme sans valeur)

            //Pour chaque parametres
            foreach ($params as $item => $value) {
                //Decouper le nom du champ en fonction du "-"
                $actualElt = explode("-", $item);


                //si mon item existe ainsi que sa valeur alors
                if (isset($item) && isset($value)) {
                    //Si ce n'est pas l'element est different de view alors
                    if($actualElt[1] != 'view') {
                            //si mon tableau des vues est vide alors
                            //je cree la requete avec la partie patient
                            //sinon sans la partie patient
                            if (count($seenID) == 0) {
                                if(count(array_keys($seenID,$actualElt[0]))==0){
                                    $request .= $this->createRequestPart("base", "");
                                    $request .= $this->createRequestPart("nomenclature", $actualElt[0]);
                                    $request .= $this->createRequestPart('unite', $actualElt[2]);
                                    $request .= $this->createRequestPart($actualElt[1], $value);
                                }else{
                                    $request .= $this->createRequestPart($actualElt[1], $value);
                                }
                            } else {
                                if(count(array_keys($seenID,$actualElt[0]))==0){
                                    $request .= $this->createRequestPart("intersect", "");
                                    $request .= $this->createRequestPart("base", "");
                                    $request .= $this->createRequestPart("nomenclature", $actualElt[0]);
                                    $request .= $this->createRequestPart('unite', $actualElt[2]);
                                    $request .= $this->createRequestPart($actualElt[1], $value);
                                }else{
                                    $request .= $this->createRequestPart($actualElt[1], $value);
                                }
                            }

                            //Ajout de l'id dans mon tableau des vues
                            array_push($seenID, $actualElt[0]);

                        $end = true;
                    }else{ //Sinon ajout dans la sesion des id d biochemistry a voir
                        Session::push('biochemistryToView', $actualElt[0].'-'.$actualElt[2]);
                        dd(Session::get('biochemistryToView'));
                    }
                }
            }

            if($end){
                $request .= $this->createRequestPart("patient", createList(Session::get('patientID')));
                $request .= $this->createRequestPart("cid", createList(Session::get('cidID')));
            }


            if($request != ""){
                $res = DB::SELECT($request);

                //Si il y a des resultats -> session
                //sinon message d'erreur et retour arriere avec les données
                if(count($res)){
                    Session::put('patientID', createArray($res, 'Patient_ID'));
                    Session::put('save-patientID-4', createArray($res, 'Patient_ID'));

                }else{
                    Session::flash('nothing',"No data found with your criteria");
                    return redirect()->route('biochemistry')->withInput();
                }
            }else{
                Session::put('patientID',Session::get('save-patientID-3'));
            }
        }



        return redirect()->route('activities');
    }



    /**
     *
     *
     * @param $part le nom de la partie que l'on veut creer
     * @param $data les donnes a concatener dans la chaine de requete
     * @return string la partie de requete demandee
     */
    public function createRequestPart($part,$data){
        $return="";
        switch ($part) {
            case "base":
                $return = " SELECT distinct b.Patient_ID Patient_ID
                           FROM biochemistry b
                           ";
                break;
            case "nomenclature":
                $return = " WHERE b.Nomenclature_ID = ".$data;
                break;
            case "unite":
                $return = " AND b.Unite_Mesure_ID = ".$data;
                break;
            case "from":
                $return = " AND b.value >= ".$data;
                break;
            case "to":
                $return = " AND b.value <= ".$data;
                break;
            case "intersect":
                $return = " INTERSECT ";
                break;
            case "patient":
                $return = "  AND b.Patient_ID in  ".$data;
                break;
            case "cid":
                $return = "  AND b.CID_ID in  ".$data;
                break;
        }

        return $return;
    }



    /**
     * Permet de creer un tableau avec les familles uniques
     *
     * @param $concerned les donnees biochemistry concernees
     * @return array
     */
    public function getUniqueFamily($concerned){
        $unique = array();
        foreach ($concerned as $item ){
               $unique[$item->Family_ID] = $item->NameF;
        }
        return $unique;
    }



    /**
     * Retourne les nom de variables concernees dans biochemistry
     *
     * @return mixed
     */
    public function getConcernedBIO(){
        $concerned = DB::SELECT('SELECT  b.Nomenclature_ID, n.NameN, u.Unite_Mesure_ID, u.NameUM, f.NameF, f.Family_ID,
                                  min(b.value) as min, max(b.value) as max
                                 FROM biochemistry b, nomenclatures n, unite_mesure u, families f
                                 WHERE b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                 AND b.Nomenclature_ID = n.Nomenclature_ID 
                                 AND n.Family_ID = f.Family_ID
                                 AND b.Patient_ID in'. createList(Session::get('patientID')).
                                'AND b.CID_ID in'. createList(Session::get('cidID')).
                                ' GROUP BY 1,2,3,4,5,6
                                ORDER BY n.NameN');
        return $concerned;
    }
}
