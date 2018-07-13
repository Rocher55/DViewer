<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Food;

class FoodController extends Controller
{
    public  function  index(){
        $patient=Session::get('save-patientID-2');
        Session::put('save-patientID-3', $patient);
        $result = Food::whereIn('Patient_ID',Session::get("patientID"))->count();

        if($result > 0){
            return view('Forms.food', compact('result'));
        }else{
            return redirect()->route("biochemistry");
        }

    }


    /**
     * Traitement des donnees postees
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSelect()    {
        $params = Input::except('_token');  //Recuperation de tous les Input sauf le token
        $request = "";                     //String de la requete
        $previousPath = Session::get('previous');

        if (Session::has('save-patientID-2') and $previousPath=='/research/biochemistry'){
            $patient = Session::get('save-patientID-2');
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
                            $request .= $this->createRequestPart($actualElt[1], $value);
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
                $request .= $this->createRequestPart("patient", createList(Session::get('patientID')));
            }

            if($request != ""){
                $res = DB::SELECT($request);

                //Si il y a des resultats -> session
                //sinon message d'erreur et retour arriere avec les données
                if(count($res)){
                    Session::put('patientID', createArray($res, 'Patient_ID'));
                    Session::put('save-patientID-3', createArray($res, 'Patient_ID'));
                }else{
                    Session::flash('nothing',"No data found with your criteria");
                    return redirect()->route('food')->withInput();
                }
            }else{
                Session::put('patientID',Session::get('save-patientID-2'));
            }
        }

        return redirect()->route('biochemistry');
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
                $return = " SELECT distinct f.Patient_ID Patient_ID
                           FROM food_diaries f, unite_mesure u, nomenclatures n 
                           WHERE f.Nomenclature_ID = n.Nomenclature_ID
                           AND f.Unite_Mesure_ID = u.Unite_Mesure_ID
                           AND f.Valeur > 0";
                break;
            case "nomenclature":
                    $return = " AND n.Nomenclature_ID = ".$data;
                break;
            case "from":
                $return = " AND f.valeur >= ".$data;
                break;
            case "to":
                $return = " AND f.valeur <= ".$data;
                break;
            case "unite":
                $return = " AND u.Unite_Mesure_ID = ".$data;
                break;
            case "intersect":
                $return = " INTERSECT ";
                break;
            case "patient":
                $return = "  AND f.Patient_ID in  ".$data;
                break;
        }

        return $return;
    }





    /**
     * Prend en entree un tableau (nom dans le form | valeur)
     * pour les id differents contenu dans le nom sous forme id-method
     *
     * EX : 168-from, 168-unite
     *
     * @param $array
     * @return $array
     */
    public function uniqueID($array){
        $allID = array();

        //Pour chaque element
        foreach($array as $item => $value){

            //si la valeur existe et est non nulle alors
            //je decoupe ma clef selon "-"
            // et j'ajoute la premiere partie dans le tableau
            if(isset($value) && isset($item)) {
                $key = explode("-", $item);
                array_push($allID, $key[0]);
            }
        }
        //Inversion des clefs/valeurs puis retour des clefs
        $uniqueID = array_keys(array_flip($allID));

        //retour des clefs
        return $uniqueID;
    }

}
/*
 * SELECT distinct n.NameN, GROUP_CONCAT( distinct u.NameUM) FROM food_diaries f, nomenclatures n, unite_mesure u
where f.Nomenclature_ID = n.Nomenclature_ID
and f.Unite_Mesure_ID = u.Unite_Mesure_ID
group by n.NameN
 * */