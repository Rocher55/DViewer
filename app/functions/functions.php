<?php
use App\Patient;

/**
 * Recupere le npourcentage de femmes encore concernees dans l'etude
 */
    function womanPercentage(){
        $nb = Patient::whereIn('Patient_ID', Session::get('patientID'))->where('sex',2)->count();
        $total = count(Session::get('patientID'));
        Session::put('percentage', round(($nb/$total)*100,0));
    }

/**
 * Permet de generer une tableau comprehensible pour
 * effectuer un "in" dans une requete ELOQUENT
 *
 * @param $data
 * @return string
 */
    function createArray($data, $column){
        $return = array();
        foreach ($data as $item) {
            array_push($return, strval($item->$column));
        }
        return $return;
    }






/**
 * Permet de generer une liste comprehensible pour
 * effectuer un "in" dans une requete SQL normale
 *
 * @param $data
 * @return string
 */
     function createList($data){
        $return=" ( ";
        foreach ($data as $item){
            $return .= $item .", ";
        }
        $return = substr($return, 0, -2) ." ) ";

        return $return;
    }



/**
 * Permet de generer une liste de string comprehensible pour
 * effectuer un "in" dans une requete SQL normale
 *
 * @param $data
 * @return string
 */
    function createStringList($data){
        $return=" ( ";
        foreach ($data as $item){
            $return .= "'".$item ."', ";
        }
        $return = substr($return, 0, -2) ." ) ";

        return $return;
    }
?>