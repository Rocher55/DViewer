<?php

namespace App\Http\Controllers;

use App\Biochemistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BiochemistryController extends Controller
{
    /** Recuperation des données pour affichage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  index(){
        //cf. fonction
        $concerned = $this->getConcernedBIO();

        $family = $this->getUniqueFamily($concerned);
        asort($family);

        return view('Forms.biochemistry', compact('family','concerned'));
    }



    public function postSelect(){

    }






















    /**
     * Permet de creer un tableau avec les familles uniques
     *
     * @param $concerned les donnees biochemistry concernees
     * @return array
     */
    public function getUniqueFamily($concerned){
        $unique = array();
        foreach ($concerned as $item ){
               $unique[$item->Family_ID] = $item->NameF;
        }
        return $unique;
    }



    /**
     * Retourne les nom de variables concernees dans biochemistry
     *
     * @return mixed
     */
    public function getConcernedBIO(){
        $concerned = DB::SELECT('SELECT DISTINCT b.Nomenclature_ID, n.NameN, u.NameUM, f.NameF, f.Family_ID
                                 FROM biochemistry b, nomenclatures n, unite_mesure u, families f
                                 WHERE b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                 AND b.Nomenclature_ID = n.Nomenclature_ID 
                                 AND n.Family_ID = f.Family_ID
                                 AND b.Patient_ID in'. $this->createList(Session::get('patientID')).
                                'AND b.CID_ID in'. $this->createList(Session::get('cidID')).
                                'ORDER BY n.NameN');
        return $concerned;
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete SQL normale
     *
     *
     * @param $data
     * @return string
     */
    public function createList($data){
        $return=" ( ";
        foreach ($data as $item){
            $return .= $item .", ";
        }
        $return = substr($return, 0, -2) ." ) ";

        return $return;
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete ELOQUENT
     *
     *
     * @param $data
     * @return string
     */
    public function createArray($data, $column){
        $return=array();
        foreach ($data as $item){
            array_push($return,$item->$column);
        }
        return $return;
    }
}
