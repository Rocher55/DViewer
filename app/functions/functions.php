<?php
/**
 * Permet de generer une tableau comprehensible pour
 * effectuer un "in" dans une requete ELOQUENT
 *
 * @param $data
 * @return string
 */
function createArray($data, $column)
{
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