<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Patient_Week;
use App\Protocol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class tests extends Controller{
    public function index(){
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