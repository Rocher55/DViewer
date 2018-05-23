<?php

namespace App\Http\Controllers;

use App\Biochemistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BiochemistryController extends Controller
{

    public  function  index(){

        //Recuperation des biochemistryID et ajout en session
        $biochemistryID = $this->getBiochemistryID();
        //Session::put('biochemistryID', $biochemistryID);

        $concerned = $this->getConcernedBIO();


        //return view('Forms.biochemistry');
        return view('test', compact('concerned'));
    }


    /**
     * Retourne les nom de variables concernees dans biochemistry
     *
     * @return mixed
     */
    public function getConcernedBIO(){
        $concerned = DB::SELECT('SELECT DISTINCT b.Nomenclature_ID, n.NameN, u.NameUM, f.NameF
                                 FROM biochemistry b, nomenclatures n, unite_mesure u, families f
                                 WHERE b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                 AND b.Nomenclature_ID = n.Nomenclature_ID 
                                 AND n.Family_ID = f.Family_ID
                                 AND b.Patient_ID in'. $this->createList(Session::get('patientID'),'Patient_ID').
                                'ORDER BY n.NameN');

        return $concerned;
    }





    /**
     * Permet de recuperer les biochemistryID concernant les patients et cid
     *
     * @return mixed
     */
    public function getBiochemistryID(){
        $biochemistryID = Biochemistry::whereIn('Patient_ID', $this->createArray(Session::get('patientID'),'Patient_ID'))
            ->whereIn('CID_ID', $this->createArray(Session::get('cidID'), 'CID_ID'))
            ->orderBy('biochemistry_ID', 'ASC')
            ->get(['biochemistry_ID']);

        return $biochemistryID;
    }



    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete SQL normale
     *
     *
     * @param $data
     * @return string
     */
    public function createList($data, $column){
        $return=" ( ";
        foreach ($data as $item){
            $return .= $item->$column .", ";
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
