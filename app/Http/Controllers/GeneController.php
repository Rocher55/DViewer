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


    public function index(){
        womanPercentage();
        return view('Forms.genes');
    }



    public function postSelect(){
        $request = Input::get('genes');

        if(isset($request)){
            //Suppression des espaces et explosion selon ';'
            $geneArray = explode(";",strtoupper(str_replace(" ","",$request)));
            $geneArray = array_unique($geneArray);


            $id = Gene::whereIn('Gene_Symbol',$geneArray)->select('Gene_ID')->groupBy('Gene_ID')->get();
            Session::put('geneID', createArray($id, 'Gene_ID'));
            Session::put('geneSymbol', array_values($geneArray));
        }


        return redirect()->route('result');
    }

}
