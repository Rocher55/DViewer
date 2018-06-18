<?php


namespace App\Http\Controllers;


use App\Nomenclature;
use App\Cid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResultController extends Controller
{
    public function index(){
        $bioCid = $this->createBioCidArray();
        $request = $this->createRequest($bioCid);
        $array = array();


        $results = DB::SELECT($request);

        foreach($results as $item) {
            $array[$item->SUBJID]['Sex']=$item->Sex;
            $array[$item->SUBJID]['Center']=$item->Center;
            $array[$item->SUBJID]['Protocol']=$item->Protocol;
            $array[$item->SUBJID]['Class']=$item->Class;
            $array[$item->SUBJID][$item->item]=$item->valeur;

        }

        $keys = array_keys($array)  ;

        return view('test', compact('array', 'request', 'bioCid', 'keys'));
    }







    public function createRequest($bioCid){
        $request = " SELECT  p.SUBJID, p.Sex as Sex,
                            CONCAT(c.Center_Acronym, ' - ', c.Center_City, ' - ', c.Center_Country) AS Center,
                             prot.Protocol_Name as Protocol, p.Class as Class, ";

        $request.= " CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) as item, b.valeur as valeur" ;

        $request .= " FROM centers c, protocols prot, center_protocol c_p, patients p, 
                                                              cid_patient cp, cids cid, biochemistry b, nomenclatures n, unite_mesure u
                                                        WHERE c_p.Center_ID = c.Center_ID
                                                        AND c_p.Protocol_ID = prot.Protocol_ID
                                                        AND p.Protocol_ID = c_p.Protocol_ID
                                                        AND p.Center_ID = c_p.Center_ID
                                                        AND cp.CID_ID = cid.CID_ID
                                                        AND cp.Patient_ID = p.Patient_ID
                                                        AND b.CID_ID = cp.CID_ID
                                                        AND b.Patient_ID = cp.Patient_ID
                                                        AND b.Nomenclature_ID = n.Nomenclature_ID
                                                         AND b.Unite_Mesure_ID = u.Unite_Mesure_ID ";

        $request .=" AND CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) in".$this->createList($bioCid).
                    " AND p.Patient_ID in".createList(Session::get('patientID'));
        //$request.=" ORDER BY 6 ;";

        return $request;
    }





    /**
     * Genere un tableau contenant des valeurs au format :
     *              Nomenclature->NameN - Cid->CID_Name
     * @param $cids
     * @param $nomenclatures
     * @return array
     */
    public function createBioCidArray(){
        $cids = Cid::whereIn('CID_ID', Session::get('cidID'))->orderBy('CID_ID', 'ASC')->get(['CID_Name']);
        $i =0;
        $request ="";

        foreach (Session::get('biochemistryToView') as $item){
            $actualElt = explode("-", $item);
            if ($i == 0) {
                $request .= '( SELECT  n.NameN as NameN,  u.NameUM as NameUM
                                            FROM biochemistry b, nomenclatures n, unite_mesure u
                                            WHERE b.Nomenclature_ID = n.Nomenclature_ID
                                            AND b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                            AND n.Nomenclature_ID = '. $actualElt[0]
                                            .' AND u.Unite_Mesure_ID = '. $actualElt[1].' ) ';
                $i++;
            }else{
                $request .= ' UNION ( SELECT  n.NameN as NameN,  u.NameUM as NameUM
                                            FROM biochemistry b, nomenclatures n, unite_mesure u
                                            WHERE b.Nomenclature_ID = n.Nomenclature_ID
                                            AND b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                            AND n.Nomenclature_ID = '. $actualElt[0]
                                            .' AND u.Unite_Mesure_ID = '. $actualElt[1].' ) ';
            }
        }
        $nomenclatures = DB::SELECT($request .' ORDER BY 1');

        $array = [];
        foreach ($nomenclatures as $item){
            foreach ($cids as $meti){
                array_push($array, $item->NameN.' ('.$item->NameUM .') - '.$meti->CID_Name);
            }
        }
        return $array;
    }






    /**
     * Permet de generer une liste comprehensible pour
     * effectuer un "in" dans une requete SQL normale
     *
     * @param $data
     * @return string
     */
    function createList($data){
        $return=" ( ";
        foreach ($data as $item){
            $return .= "'".$item ."', ";
        }
        $return = substr($return, 0, -2) ." ) ";

        return $return;
    }

}