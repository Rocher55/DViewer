<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
   public function ajax_call(){

        $term = Request::query('term');
        $limit = Request::query('maxRows');

        $listAnalyseID = $this->createList(Session::get('analyseID'),'');

       $result = DB::SELECT("SELECT distinct concat(Gene_Symbol, ' | ', Probe_ID) FROM `experiments`
                             WHERE value1 != -9999
                             AND value1 NOT LIKE '-%'
                             AND Analyse_ID in ". $listAnalyseID.
                            "AND concat(Gene_Symbol, ' | ', Probe_ID) LIKE '".$term."%'".
                             "ORDER BY 1
                             LIMIT ". $limit);


       echo json(array("gene"=>$result),200);
   }
    /*

 SELECT distinct concat(Gene_Symbol, '-', Probe_ID), concat(Gene_Symbol, ' - ', Probe_ID) FROM `experiments`
 WHERE Analyse_ID in ( 3594, 3610, 3628)
 AND value1 != -9999
 and value1 NOT LIKE "-%"
 ORDER BY 1

  * */


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
