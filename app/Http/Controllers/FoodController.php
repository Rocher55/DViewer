<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Food;

class FoodController extends Controller
{
    public  function  index(){


        return view('Forms.food');
    }
}
/**
 * Exemple de requete
 *
 *
    SELECT  *
    FROM food_diaries f, unite_mesure u, nomenclatures n
    WHERE f.Nomenclature_ID = n.Nomenclature_ID
    AND f.Unite_Mesure_ID = u.Unite_Mesure_ID
    and( n.Nomenclature_ID =165 and  f.Valeur<=12 and f.Valeur >=1 and u.Unite_Mesure_ID = 34)
    and Patient_ID in (SELECT  DISTINCT Patient_ID
                       FROM food_diaries f, unite_mesure u, nomenclatures n
                       WHERE f.Nomenclature_ID = n.Nomenclature_ID
                       AND f.Unite_Mesure_ID = u.Unite_Mesure_ID
                       AND( n.Nomenclature_ID =166 and  f.Valeur<=230 and u.Unite_Mesure_ID = 34))
    ORDER BY `f`.`Patient_ID` ASC
 * */