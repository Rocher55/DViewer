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


class SelectController extends Controller
{
    /**
     * Affiche l'accueil.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Recuperation des "nomenclature_id" differents
        $bio_id = Biochemistry::distinct()->pluck('nomenclature_id') ;

        //Avec chacun des id on recupere le contenu de la table nomenclature
        $nomenclatures = Nomenclature::whereIn('nomenclature_id', $bio_id )->orderBy("NameN")->get() ;
        $i = 1;
        return view('select', compact('nomenclatures'));
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
        $data = Input::get('select');

        Session::put('bioToView',$data);
        return view('test', compact('data'));
    }
}
