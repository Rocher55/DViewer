<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
   public function ajax_call(){

       $term = strtoupper(Input::get('recherche'));
       $limit = 100;
       $return = array();

        $tabAnalyseID = Session::get('analyseID');

       $results = DB::SELECT("SELECT distinct concat(Gene_Symbol, ' | ', Probe_ID) as 'gene', Analyse_ID as 'analyse' FROM `experiments`
                              WHERE value1 != -9999                         
                              AND concat(Gene_Symbol, ' | ', Probe_ID) LIKE '".$term."%'".
                             "LIMIT ". $limit);


       foreach ($results as $item) {
           if((in_array($item->analyse, $tabAnalyseID)) ) {
               array_push($return, $item->gene);
           }
       }

       $return = array_unique($return);

       return Response::json($return,200);
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
