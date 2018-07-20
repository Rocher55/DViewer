<?php

namespace App\Http\Controllers;

use App\Protocol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $protocols = DB::select(' SELECT prot.Protocol_ID, prot.Protocol_Name, count( distinct p.Patient_ID) as nb, 
                                         GROUP_CONCAT(DISTINCT p.Class) as class, min(p.age) as min, max(p.age) as max
                                         FROM protocols prot, center_protocol cp, patients p 
                                         WHERE prot.Protocol_ID = cp.Protocol_ID 
                                         AND cp.Protocol_ID = p.Protocol_ID 
                                         GROUP BY 1');

        Session::flush();
        Session::regenerate();
        return view('start', compact('protocols'));
    }
}
