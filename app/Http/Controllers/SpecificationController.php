<?php

namespace App\Http\Controllers;

use App\Specification;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SpecificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index($id){
        Session::flush();
        Session::regenerate();

        $specification = Specification::where('Protocol_ID', $id)->first();

        if($specification){
            return view('specification', compact('specification'));
        }  else {
            return redirect('/')->with('error','This protocol doesn\'t exist');
        }

        
    }


    public function post(){
        Session::push('protocolID', Input::get('protocol'));
        return redirect()->route('center');
    }
}
