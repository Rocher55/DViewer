<?php

namespace App\Http\Controllers;

use App\Gene;
use App\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GeneController extends Controller
{


    public function index(){
        //$result = Gene::get();

        $result = DB::SELECT("SELECT distinct concat(Gene_Symbol, '|', Probe_ID) as 'un', concat(Gene_Symbol, ' | ', Probe_ID) as 'deux' FROM `experiments`
                              WHERE value1 != -9999
                              AND value1 NOT LIKE '-%'
                              
                              AND Analyse_ID in ( 3594, 3610, 3628)
                              ORDER BY 1
                              LIMIT 500");

        return view('Forms.genes', compact('result'));
    }
}
/*

SELECT distinct concat(Gene_Symbol, '-', Probe_ID), concat(Gene_Symbol, ' - ', Probe_ID) FROM `experiments`
WHERE Analyse_ID in ( 3594, 3610, 3628)
AND value1 != -9999
and value1 NOT LIKE "-%"
ORDER BY 1

 * */