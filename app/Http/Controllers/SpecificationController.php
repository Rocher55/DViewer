<?php

namespace App\Http\Controllers;

use App\Specification;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function index($id){
        $specification = Specification::where('Protocol_ID', $id)->first();

        if($specification){
            return view('specification', compact('specification'));
        }  else {
            return redirect('/')->with('error','This protocol doesn\'t exist');
        }

        
    }
}
