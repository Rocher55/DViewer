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

            if(count($id)>0){
                Session::put('geneID', createArray($id, 'Gene_ID'));
                Session::put('geneSymbol', array_values($geneArray));
            }else{
                Session::flash('nothing',"Gene doesn't exist");
                return redirect()->route('select-gene')->withInput();
            }

        }


        return redirect()->route('result');
    }

}
