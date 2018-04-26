<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocol;

class ProtocolController extends Controller
{
    public function index()
    {
        //Recupere les protocoles tries par type & nom croissant
        $protocols = Protocol::orderBy('Protocol_Type','ASC')->orderBy('Protocol_Name', 'ASC')->get() ;

        return view('protocol',compact('protocols'));
    }




    /**
     *  Traite les données souhaitant être affichées
     *
     * Store dans une session les données
     *  @return \Illuminate\Http\Response
     */
    public function postSelect()
    {
        return view('test');
    }

}
