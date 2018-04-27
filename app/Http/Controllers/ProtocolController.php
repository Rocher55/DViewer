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

            $protocols = Protocol::get(['Protocol_ID']);
            foreach($protocols as $protocol) {
                Session::push('protocolID', $protocol->Protocol_ID);
            }
        }



        //Position actuelle dans le tableau du chemin a suivre
        $position = array_search($this->lastURLPart(), Session::get('whereToSearch'));

        //Si il n'y a pas de page suivante alors direction le choix des données biochimique
        if(isset(Session::get('whereToSearch')[$position+1])){
            return redirect()->route(Session::get('whereToSearch')[$position+1]);
        }else{
            return redirect()->route('select');
        }
    }


    /**
     *  Retourne la derniere partie de l'URL
     *
     *  @return une chaine
     */
    public function lastURLPart(){
        $urlPlusKey = URL::current();
        $urlArray = explode('/', $urlPlusKey);
        return end($urlArray);
    }

}
