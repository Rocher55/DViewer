<?php

namespace App\Http\Controllers;

use App\Experiment;
use App\Gene;
use App\Patient;
use App\Patient_Week;
use App\Physical_activities;
use App\Protocol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class tests extends Controller{


    public function index(){
        return view('test');
    }





    /**
     * Met àa jour la colonne Gene_ID de la table experiments avec les Gene_ID de genes
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateGeneIDExperiments(){

        $update = DB::update(" UPDATE experiments e 
                                     SET e.Gene_ID = (SELECT g.Gene_ID FROM genes WHERE g.Gene_Symbol = e.Gene_Symbol AND g.Probe_ID = e.Probe_ID)
                                     WHERE e.Gene_ID = 0 ");

        return view('test');
    }





    /**
     * Permet d'ajouter les genes présent dans experiments et non dans genes
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function geneInExperimentsNotInGene(){
        $diff = DB::select("SELECT e.Gene_Symbol, e.Probe_ID FROM experiments e
                                   except
                                   SELECT g.Gene_Symbol, g.Probe_ID FROM genes g");

        foreach($diff as $item){
            $gene = new Gene();

            $gene->Gene_Symbol = $item->Gene_Symbol;
            $gene->Probe_ID = $item->Probe_ID;

            $gene->save();
        }

        return view('test', compact('diff'));
    }


    /**
     * Recupere l'image dans la bd au format blob
     * conversion en base64 pour affichage avec
     * <img src="{{--$third--}}" width="879" height="657"/>     ----data:image/png;base64,
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function image(){
        /*
        $connexion = ldap_connect("ldaps://ldap1.inserm.fr");
        $set = ldap_set_option($connexion, LDAP_OPT_PROTOCOL_VERSION, 3);
        $bind = @ldap_bind($connexion,'uid=ldapreader-toul,ou=sysusers,dc=local', 'YeEa#hh6e');
        $error = ldap_error($connexion);
        */
        $base = DB::select("SELECT CONCAT( TO_BASE64(image)) AS image 
                                    FROM protocols 
                                    WHERE Protocol_ID = 1");

        $other = DB::select("SELECT CONCAT('data:image/png;base64,', TO_BASE64(image)) AS image 
                                    FROM protocols 
                                    WHERE Protocol_ID = 1");

        foreach ($other as $item){
            $third = $item->image;
        }

        return view('test', compact('base', 'other', 'third'));
    }


    /**
     * Permet de mettre a jour la colonne de l'index de Baecke
     * en faisant a somme des 3 autres(sport, work, leisure)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function majBaeckeIndex(){
        $pas = Physical_activities::where('Baecke Work', '>',0)
                                    ->where('Baecke Sport', '>',0)
                                    ->where('Baecke Leisure', '>',0)->whereNull('Baecke index total')->get();

        foreach ($pas as $pa){
            Physical_activities::where('Physical_Activities_ID', $pa->Physical_Activities_ID)
                ->update(['Baecke index total' => $pa['Baecke Work']+$pa['Baecke Sport']+$pa['Baecke Leisure']]);
        }

        $pas = Physical_activities::where('Baecke Work', '>',0)
                                        ->where('Baecke Sport', '>',0)
                                        ->where('Baecke Leisure', '>',0)
                                        ->get();

        return view('test', compact('pas'));
    }

}



/*
 Ajout des tuples n'existant pas dans patient_week mais dans food_diaries
$toInsert = DB::SELECT(" select distinct f.Patient_ID as Patient_ID, f.WK_ID as WK_ID
                      from food_diaries f
                      except
                      select distinct pw.Patient_ID as Patient_ID, pw.WK_ID as WK_ID
                      from patient_week pw");

        foreach ($toInsert as $item){
            $pw = new Patient_Week;

            $pw->Patient_ID = $item->Patient_ID;
            $pw->WK_ID = $item->WK_ID;

            $pw->save();
        }
 */