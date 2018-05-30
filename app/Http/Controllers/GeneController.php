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
        return view('Forms.genes');
    }
}
