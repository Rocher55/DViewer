<?php

namespace App\Http\Controllers;

use App\Gene;
use Illuminate\Http\Request;

class GeneController extends Controller
{


    public function index(){
        $result = Gene::get();

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