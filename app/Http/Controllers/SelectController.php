<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('select');
    }



    /**
     *  Traite les données souhaitant être affichées
     *
     * Store dans une session les données
     *  @return \Illuminate\Http\Response
     */
    public function postSelect()
    {



        return view('home');
    }
}
