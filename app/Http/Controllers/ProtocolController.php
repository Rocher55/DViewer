<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocol;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


class ProtocolController extends Controller
{
    public function index()
    {
        //Recupere les protocoles tries par type & nom croissant
        $protocols = Protocol::orderBy('Protocol_Type','ASC')->orderBy('Protocol_Name', 'ASC')->get() ;

        return view('Forms.protocol',compact('protocols'));
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
        $data = Input::get('protocol');

        //Vérification de la saisie,
        //si existe alors ->sesion
        //sinon recuperation de tous les id et ajout en sesion
        if (isset($data)){
            //Stockage dans une session
            Session::put('protocolID',$data);
        }else{

            //Recuperation de tous les "id de protocol"
            $protocols = Protocol::get(['Protocol_ID']);


                Session::put('protocolID', $protocols);

        }
            return redirect()->route('center');

    }



}
