<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiochemistryController extends Controller
{
    public  function  index(){
        return view('Forms.biochemistry');
    }
}
