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

        Session::flush();
        Session::regenerate();

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
        //si existe alors -> session
        //sinon recuperation de tous les id et ajout en session
        if (isset($data)){
            //Stockage dans une session
            Session::put('protocolID',$data);

        }else{
            //Recuperation de tous les "id de protocol"
            $protocols = Protocol::get(['Protocol_ID']);
            Session::put('protocolID', $this->createArray($protocols, 'Protocol_ID'));
        }
            return redirect()->route('center');
    }




    /**
     * Permet de generer une liste comprehensible pour
     * effectuer pour ajouter en session
     *
     * @param $data
     * @return string
     */
    public function createArray($data, $column){
        $return=array();
        foreach ($data as $item){
            array_push($return, strval($item->$column));
        }
        return $return;
    }

}
