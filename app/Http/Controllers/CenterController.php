<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Center;
use App\Center_protocol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class CenterController extends Controller
{
    public function index()
    {
        //Recupere les centres tries par pays, ville & acronym croissant
        $centersId = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))->get(['Center_ID']);
        $centers = Center::whereIn('Center_ID', $centersId)->orderBy('Center_Country', 'ASC')->orderBy('Center_City', 'ASC')->orderBy('Center_Acronym', 'ASC')->get();

        return view('Forms.center', compact('centers'));
    }


    /**
     *  Traite les données souhaitant être affichées
     *
     * Store dans une session les données
     * @return \Illuminate\Http\Response
     */
    public function postSelect()
    {
        //Recupere les données du select a choix multiple
        $data = Input::get('center');

        //Vérification de la saisie,
        //Si existe alors création d'une sesion avec les donnees de center_protocol concernees
        //sinon

        if (isset($data)) {

            $cid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->whereIn('Center_ID', $data)
                ->get(['Center_ID']);

            $pid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->whereIn('Center_ID', $data)
                ->get(['Protocol_ID']);

            Session::put('centerID', $cid);
            Session::put('protocolID', $pid);



        } else {

            $cid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->get(['Center_ID']);
            $pid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->get(['Protocol_ID']);

            Session::put('centerID', $cid);
            Session::put('protocolID', $pid);

        }

        return redirect()->route('patient');
    }
}


