<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Center;
use App\Center_protocol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class CenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        //Recupere les centres tries par pays, ville & acronym croissant
        //$centersId = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))->get(['Center_ID']);
       /* $centers = Center::Select('Center_ID','Center_Country','Center_City','Center_Acronym')
            ->whereIn('Center_ID', $centersId)
            ->orderBy('Center_Country', 'ASC')
            ->orderBy('Center_City', 'ASC')
            ->orderBy('Center_Acronym', 'ASC')
            ->get();
       */
        $centers=Center::Select('centers.Center_ID','Center_Country','Center_City','Center_Acronym')
            ->join('center_protocol','center_protocol.Center_ID','=','centers.Center_ID')
            ->join('protocols','protocols.Protocol_ID','=','center_protocol.Protocol_ID')
            ->whereIn('protocols.Protocol_ID', Session::get('protocolID'))
            ->orderBy('Center_Country', 'ASC')
            ->orderBy('Center_City', 'ASC')
            ->orderBy('Center_Acronym', 'ASC')
            ->get();
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
                ->distinct()
                ->get(['Center_ID']);

            $pid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->whereIn('Center_ID', $data)
                ->distinct()
                ->get(['Protocol_ID']);


           Session::put('centerID', createArray($cid, 'Center_ID'));
           Session::put('protocolID', createArray($pid, 'Protocol_ID'));


        } else {

            $cid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->distinct()
                ->get(['Center_ID']);
            $pid = Center_protocol::whereIn('Protocol_ID', Session::get('protocolID'))
                ->distinct()
                ->get(['Protocol_ID']);

            Session::put('centerID', createArray($cid, 'Center_ID'));
            Session::put('protocolID', createArray($pid, 'Protocol_ID'));

        }

        return redirect()->route('patient');
    }

}


