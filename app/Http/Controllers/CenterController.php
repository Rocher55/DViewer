<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Center;
use App\Center_protocol;
use Illuminate\Support\Facades\Session;

class CenterController extends Controller
{
    public function index()
    {
        //Recupere les centres tries par pays, ville & acronym croissant
        $centersId = Center_protocol::whereIn('Protocol_ID' , Session::get('protocolID'))->get(['Center_ID']) ;
        $centers = Center::whereIn('Center_ID' , $centersId)->orderBy('Center_Country','ASC')->orderBy('Center_City', 'ASC')->orderBy('Center_Acronym', 'ASC')->get() ;

        return view('Forms.center',compact('centers'));
    }




    /**
     *  Traite les données souhaitant être affichées
     *
     * Store dans une session les données
     *  @return \Illuminate\Http\Response
     */
    public function postSelect()
    {
        //Recupere les données du select a choix multiple
        $data = Input::get('center');

        //Vérification de la saisie,
        //Si existe alors création d'une sesion avec les donnees de center_protocol concernees
        //sinon

        if (isset($data)){
            //Stockage dans une session
            $cp = Center_protocol::whereIn('Protocol_ID' , Session::get('protocolID'))->whereIn('Center_ID', $data)->get();



            Session::put('centerID',$data);
        }else{

            $center_protoclID = Center_protocol::whereIn('Protocol_ID' , Session::get('protocolID'))->get() ;



            //Pour chaque id, ajout en session
            foreach($protocols as $protocol) {
                Session::push('protocolID', $protocol->Protocol_ID);
            }
        }
        return redirect()->route('center');

    }

}
