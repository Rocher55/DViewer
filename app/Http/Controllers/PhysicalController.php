<?php

namespace App\Http\Controllers;

use App\Physical_activities;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class PhysicalController extends Controller{

    public function index(){
        $nb = Physical_activities::whereIn('Patient_ID', Session::get('patientID'))->whereIn('CID_ID', Session::get('cidID'))->count();

        if ($nb > 0 ){
            return view('Forms.activities', compact('concerned'));
        }else{
            return redirect()->route('analyse');
        }
    }




    public function postSelect(){
        Session::forget('activitiesToView');

        $params = Input::except('_token');
        if(isset($params)){
            foreach($params as $item){
                Session::push('activitiesToView', $item);
            }
        }

        return redirect()->route('analyse');
    }




}
/*
SELECT p. FROM physical_activities p
where `p`.`Baecke Work` =-1
and `p`.`Baecke Sport` =-1
and `p`.`Baecke Leisure` =-1
and `p`.`Baecke index total` is null

UNION
SELECT * FROM physical_activities p
where `p`.`Baecke Work` is null
and `p`.`Baecke Sport` is null
and `p`.`Baecke Leisure`is null
and `p`.`Baecke index total` =-1
ORDER BY `Baecke index total`  DESC
 * */