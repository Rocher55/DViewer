<?php

namespace App\Http\Controllers;


use App\Biochemistry;
use App\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;


class ConditionsController extends Controller
{
    /**
     * Affiche l'accueil.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Vide la session et en recre une
        Session::flush();
        Session::regenerate();
        return view('Forms.conditions');
    }



    /**
     *  Traite les données souhaitant être affichées
     *
     * Store dans une session les données
     *  @return \Illuminate\Http\Response
     */
    public function postSelect()
    {
        //Empeche en cas de retour de garder les valeurs precedentes et de suivre un chemin bizarre
        Session::forget('whereToSearch');
        $array = array('protocol', 'center','cid', 'patient', 'food', 'biochemistry', 'analyse', 'gene');


        foreach ($array as $item){
            if(Input::get($item) == true ){
                Session::push('whereToSearch', $item);
            }
        }
        //Ajout du nombre d'étapes
        Session::put('nbrStep',count(Session::get('whereToSearch')));
        Session::put('actualStep', '1');


        return redirect()->route(Session::get('whereToSearch')[Session::get('actualStep')-1]);
    }

}
