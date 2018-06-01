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
        return view('Forms.genes');
    }

    public function postSelect(){
        $request = Input::get('genes');

        return view('test', compact('request'));
    }
}
