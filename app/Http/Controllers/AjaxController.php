<?php

namespace App\Http\Controllers;

use App\Analyse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{
   public function genes(Request $request){
       $term = strtoupper($request->recherche);



        //Requete sans tri hormis le gene_symbol
        //whereRaw protege des injections SQL si les variables sont passées en paramètres apparemment
       $results=DB::table('genes')->select('Gene_Symbol')->whereRaw('Gene_Symbol like ?',array("%".$term."%"))->orderBy('Gene_Symbol')->distinct()->get();

      // $results = DB::select("SELECT distinct g.Gene_Symbol as gene FROM genes g WHERE g.Gene_Symbol LIKE '".$term."%' ORDER BY gene" );
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



       $return = createArray($results, 'Gene_Symbol');
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

    public function protocols(Request $request){
       $results=DB::table('protocols')->orderby('Protocol_Name')->get();
       return response()->json($results);
    }
    public function centers(Request $request){
        $results=DB::table('centers')->orderby('Center_Acronym')->get();
        return response()->json($results);
    }
    public function cids(Request $request){
        $results=DB::table('cids')->get();
        return response()->json($results);
    }
    public function existsCenterProtocol(Request $request){
       $protocolID=$request->protocolID;
       $centerID=$request->centerID;
        try {
            $results=DB::table('center_protocol')
                ->where('Center_ID','=',$centerID)
                ->where('Protocol_ID','=',$protocolID)
                ->get();

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($results);
    }

    public function patientTemplate(){
       return Storage::download('patientTemplate.csv');
    }
}
