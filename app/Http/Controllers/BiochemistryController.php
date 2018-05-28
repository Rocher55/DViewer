<?php

namespace App\Http\Controllers;

use App\Biochemistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class BiochemistryController extends Controller
{
    /** Recuperation des données pour affichage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  index(){
        Session::forget('biochemistryToView');

        //cf. fonction
        $concerned = $this->getConcernedBIO();

        $family = $this->getUniqueFamily($concerned);
        asort($family);

        return view('Forms.biochemistry', compact('family','concerned'));
    }



    public function postSelect(){
        $params = Input::except('_token');  //Recuperation de tous les Input sauf le token
        $request = "";                     //String de la requete

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

                    //Si je n'ai pas encore croise cet id alors
                    if (!in_array($actualElt[0], $seenID)) {

                        //si mon tableau des vues est vide alors
                        //je cree la requete avec la partie patient
                        //sinon sans la partie patient
                        if (count($seenID) == 0) {
                            $request .= $this->createRequestPart("base", "");
                            $request .= $this->createRequestPart("nomenclature", $actualElt[0]);
                            $request .= $this->createRequestPart($actualElt[1], $value);
                        } else {
                            $request .= $this->createRequestPart("intersect", "");
                            $request .= $this->createRequestPart("base", "");
                            $request .= $this->createRequestPart("nomenclature", $actualElt[0]);

                            if($actualElt[1] === 'view'){
                                Session::push('biochemistryToView', $value);
                            }else{
                                $request .= $this->createRequestPart($actualElt[1], $value);
                            }

                        }

                        //Ajout de l'id dans mon tableau des vues
                        array_push($seenID, $actualElt[0]);
                    } else {
                        $request .= $this->createRequestPart($actualElt[1], $value);
                    }
                    $end = true;
                }
            }

            if($end){
                $request .= $this->createRequestPart("patient", $this->createList(Session::get('patientID')));
            }

            if($request != ""){
                $res = DB::SELECT($request);

                //Si il y a des resultats -> session
                //sinon message d'erreur et retour arriere avec les données
                if(count($res)){
                    Session::put('patientID', $this->createArray($res, 'Patient_ID'));
                }else{
                    Session::flash('nothing',"Aucune donnée n'existe avec vos critères");
                    return redirect()->route('biochemistry')->withInput();
                }
            }
        }

        return redirect()->route('analyse');
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
                           FROM biochemistry b, unite_mesure u, nomenclatures n 
                           WHERE b.Nomenclature_ID = n.Nomenclature_ID
                           AND b.Unite_Mesure_ID = u.Unite_Mesure_ID
                           AND b.Valeur > 0";
                break;
            case "nomenclature":
                $return = " AND n.Nomenclature_ID = ".$data;
                break;
            case "from":
                $return = " AND b.valeur >= ".$data;
                break;
            case "to":
                $return = " AND b.valeur <= ".$data;
                break;
            case "intersect":
                $return = " INTERSECT ";
                break;
            case "patient":
                $return = "  AND b.Patient_ID in  ".$data;
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
        $concerned = DB::SELECT('SELECT DISTINCT b.Nomenclature_ID, n.NameN, u.NameUM, f.NameF, f.Family_ID
                                 FROM biochemistry b, nomenclatures n, unite_mesure u, families f
                                 WHERE b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                 AND b.Nomenclature_ID = n.Nomenclature_ID 
                                 AND n.Family_ID = f.Family_ID
                                 AND b.Valeur > 0
                                 AND b.Patient_ID in'. $this->createList(Session::get('patientID')).
                                'AND b.CID_ID in'. $this->createList(Session::get('cidID')).
                                'ORDER BY n.NameN');
        return $concerned;
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete SQL normale
     *
     *
     * @param $data
     * @return string
     */
    public function createList($data){
        $return=" ( ";
        foreach ($data as $item){
            $return .= $item .", ";
        }
        $return = substr($return, 0, -2) ." ) ";

        return $return;
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete ELOQUENT
     *
     *
     * @param $data
     * @return string
     */
    public function createArray($data, $column){
        $return=array();
        foreach ($data as $item){
            array_push($return,strval($item->$column));
        }
        return $return;
    }
}
