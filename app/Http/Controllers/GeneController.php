<?php

namespace App\Http\Controllers;

use App\Gene;
use App\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class GeneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        womanPercentage();
        return view('Forms.genes');
    }



    public function postSelect(){
        $request = Input::get('genes');

        if(isset($request)){
            //Suppression des espaces et explosion selon ';'
            $geneArray = explode(",",$request);
            $geneArray = array_unique($geneArray);



            $id = Gene::whereIn('Gene_Symbol',$geneArray)
                        ->select('Gene_ID')
                        ->groupBy('Gene_ID')
                        ->get();

            //les ids des genes correspondat à la table ea_analyse
            $matchingGenes=DB::select("select genes.Gene_ID from genes,experiments,ea_analyse 
                                        WHERE genes.Gene_ID=experiments.Analyse_ID
                                        AND experiments.Analyse_ID=ea_analyse.Analyse_ID
                                        AND  ea_analyse.Analyse_iD in".createList(Session::get('analyseID'))) ;
            //dd( Session::get('analyseID'));

            if(count($id)>0){
                Session::put('geneID', createArray($id, 'Gene_ID'));
                Session::put('geneSymbol', array_values($geneArray));
            }else{
                Session::flash('nothing',"Gene doesn't exist");
                return redirect()->route('select-gene')->withInput();
            }

            if(count($matchingGenes)==0){
                Session::flash('nothing',"No patients found for the selected genes");
                return redirect()->route('select-gene')->withInput();
            }

        }


        return redirect()->route('result');
    }

}
