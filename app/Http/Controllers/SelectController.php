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

        //Ajout en sesion au cas ou on souhaite afficher toutes les données de biochemistry
        Session::put('nomIdInBio', $nomenclatures);

        return view('Forms.select', compact('nomenclatures'));
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

        //Vérification de la saisie,
        //si existe alors ->sesion
        //sinon recuperation de tous les id et ajout en sesion
        if (isset($data)){
            //Stockage dans une session
            Session::put('bioToView',$data);
        }else{

            foreach(Session::get('nomIdInBio') as $nomId) {
                Session::push('bioToView',$nomId->Nomenclature_ID);
            }
        }
        Session::forget('nomIdInBio');

        //Change the return
       return redirect()->route('conditions');
    }
}
