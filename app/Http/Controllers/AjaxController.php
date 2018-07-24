<?php

namespace App\Http\Controllers;

use App\Analyse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
   public function genes(Request $request){
       $term = strtoupper($request->recherche);




        //Requete sans tri ormis le gene_symbol
       $results = DB::select("SELECT g.Gene_Symbol as gene FROM genes g WHERE g.Gene_Symbol LIKE '".$term."%' GROUP BY 1" );

       //Requete avec tri sur l'id de l'analyse
       /*$results = DB::select("SELECT Gene_Symbol as gene
                                     FROM genes
                                     WHERE Gene_ID in (SELECT e.Gene_ID 
                                                       FROM experiments e
                                                       WHERE e.Gene_id in (SELECT g.Gene_ID as gene 
                                                                           FROM genes g
                                                                           WHERE g.Gene_Symbol LIKE '".$term."%')
						                               AND e.Analyse_ID between ".min(Session::get("analyseID"))." AND ".max(Session::get("analyseID"))." group by 1)
						             group by 1" );
       */



       $return = createArray($results, 'gene');
       return response()->json($return);
   }







          /**
           * Recupere le chemin de l'url demandant a revenir à la page precedente
           *
           * @param Request $request
           */
   public function pathThatDemandPrevious(Request $request){
       Session::put('previous', $request->previous);
       //Session::put('previous', str_replace(url('/'), '', $_SERVER['HTTP_REFERER']));
   }




}
