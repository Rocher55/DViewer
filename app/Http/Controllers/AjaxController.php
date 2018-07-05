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


       $results = DB::SELECT("SELECT DISTINCT UPPER(Gene_Symbol) as 'gene' FROM `experiments`
                              WHERE UPPER (Gene_Symbol) LIKE '".$term."%'".
                            " AND analyse_ID in ".createList(Session::get('analyseID')).
                             " LIMIT ". $limit);


       $return = createArray($results, 'gene');
       $return = array_values(array_sort(array_unique($return)));

       return response()->json($return);
   }




}
