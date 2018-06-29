<?php

namespace App\Http\Controllers;

use App\Analyse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
   public function ajax_call(Request $request){
       $term = strtoupper($request->recherche);
       $limit = 1000;
       $return = array();


       $results = DB::SELECT("SELECT DISTINCT UPPER(Gene_Symbol) as 'gene' FROM `experiments`
                              WHERE value1 >0                       
                              AND UPPER (Gene_Symbol) LIKE '".$term."%'".
                            " AND analyse_ID in ".createList(Session::get('analyseID')).
                             " LIMIT ". $limit);

       foreach ($results as $item) {
           array_push($return, $item->gene);
       }
       $return = array_values(array_sort(array_unique($return)));

       return response()->json($return);
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
