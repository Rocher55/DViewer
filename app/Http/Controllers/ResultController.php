<?php


namespace App\Http\Controllers;


use Illuminate\Pagination\LengthAwarePaginator;
use App\Cid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResultController extends Controller{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //Tableau contenant les valeurs
        $array = array();

        //bioCid
$time = microtime(true);
        $bioCid = $this->createBioCidArray();
$time = microtime(true)-$time;
var_dump(' CreateBioCid '.$time);
        $requestBio = $this->createRequestBio($bioCid);


        //geneCid
        $geneCid = array();
        $newCols = array();

        //S'il ya des genes que je souhaite voir
        if(Session::has('geneID')){

            //Recuperation des genes au format
            //PCYT1A (A_24_P106057) (3-7-2) - CID2 - 1
            //Gene_Symbol (Probe_ID) (SampleType_ID-Technique_ID-Molecule_ID) - CID_Name - indice
$time = microtime(true);
            $geneCid = $this->getGeneCidArray();
$time = microtime(true)-$time;
var_dump(' CreateGeneCid '.$time);

            //Creation et execution de la requete
            $requestGene = $this->createRequestGene($geneCid);
$time = microtime(true);
            $resultsGene = DB::SELECT($requestGene);
$time = microtime(true)-$time;
var_dump(' GeneExec '.$time);

            //Pour chaque resultat
            foreach ($resultsGene as $item){
                //Si une valeur exite a cet endroit alors
                if(isset($array[strval($item->Patient_ID)][$item->item])){
                    $i=2;   //indice = 2

                    //Je cree le nom que portera la colonne
                    $newCol = substr_replace($item->item,$i,-1,1);

                    //Et temps que j'ai un resultat pour la nouvelle colonne
                    //Incrementer i et changer le nom de la colonne en fonction
                    while (isset($array[strval($item->Patient_ID)][$newCol])){
                        $i++;
                        $newCol = substr_replace($item->item,$i,-1,1);
                    }

                    //J'ajoute dans mon tableau des nouvelles colonnes la colonne
                    //ainsi que la valeur pour le patient dans la nouvelle colonne
                    $newCols[]= $newCol;
                    $array[strval($item->Patient_ID)][$newCol] = $item->valeur;
                }else{
                    //Sinon j'ajoute simplement la valeur dans la tableau
                    $array[strval($item->Patient_ID)][$item->item]=$item->valeur;
                }

                //Je garde le nom des colonnes en un exemplaire
                $newCols = array_unique($newCols);
            }

            //Si mon tableau de nouvelles colonnes existe alors je reorganise
            //mon tableau d'entete : geneCid
            if(isset($newCols)){
                $geneCid = $this->reorganizeArray($geneCid, $newCols);
            }
        }
$time = microtime(true);
        //Execution de la requete
        $resultsBio = DB::SELECT($requestBio);
$time = microtime(true)-$time;
var_dump(' ExecBio '.$time);
        //Pour chaque resultat le mettre dans
        //le tableau à l'indice 1 : Patient_ID
        //et 2 : item


        foreach($resultsBio as $item) {
            $array[strval($item->Patient_ID)]['SUBJID'] =$item->SUBJID;
            $array[strval($item->Patient_ID)]['Sex']=$item->Sex;
            $array[strval($item->Patient_ID)]['Center']=$item->Center;
            $array[strval($item->Patient_ID)]['Protocol']=$item->Protocol;
            $array[strval($item->Patient_ID)]['Class']=$item->Class;
            $array[strval($item->Patient_ID)][$item->item]=$item->valeur;
        }



        $keys = array_keys($array);              //Recuperation des cles (Patient_ID)
        $cols = array_merge($bioCid, $geneCid);  //Fusion des nom de colonnes entre Biochemistry et Genes
        $this->sendToSession($array,$keys,$cols);//Ajout du tableau de valeur, des clefs et colonnes en Session


        //Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 16;
        $path = LengthAwarePaginator::resolveCurrentPath();
        $keys = new LengthAwarePaginator(array_slice($keys, $perPage * ($currentPage - 1), $perPage), count($keys), $perPage, $currentPage, ['path' => $path]);

       return view('results', compact('array', 'cols', 'keys'));
    }






    /**
     * Ajout en session
     *
     * @param $values
     * @param $keys
     * @param $columns
     */
    public function sendToSession($values, $keys, $columns){
        Session::put('results-array', $values);
        Session::put('results-keys', $keys);
        Session::put('results-columns', $columns);
    }







    /**
     * Exportation des données en session
     *dans un fichier .csv
     *
     *La fonction est appelee par le chemin "research/export"
     */
    public function export(){
        $array = Session::get('results-array');
        $cols = Session::get('results-columns');
        $keys = Session::get('results-keys');
        $this->convert_to_csv($array, 'data_as_csv.csv', ';', $cols,$keys);
    }



    /**Permet de reorganiser un tableau
     * en ajoutant de nouvelles colonnes (arrayToAdd)
     * apres celle possedant un id inferieur
     *
     * @param $originalArray
     * @param $arrayToAdd
     */
    public function reorganizeArray( $originalArray, $arrayToAdd){
        //J'affecte dans le tableau qui sera modifie l'original
        $editedArray = $originalArray;

        //Pour chaque valeur qui se trouve dans le tableau des colonnes a ajouter
        foreach ($arrayToAdd as $item){

            $actualI = intval(substr($item,-1,1));      //je recupere l'indice de la valeur a ajouter
            $nameToSearch = substr_replace($item,$actualI-1,-1,1);  //Je defini le nom dont je vais chercher l'indice
                                                                                            //dans le tableau edite

            $key = array_search($nameToSearch, $editedArray); //je recupere la clef qui correspond

            //Si ma clef < que la taille du tableau edite -1 alors
            if($key < sizeof($editedArray)-1){
                //Pour i allant de la taille du tableau à clef+2
                for($i = sizeof($editedArray) ; $i >= $key+2 ; $i--){
                    $editedArray[$i]=$editedArray[$i-1];    //Je decale de 1 pas vers la droite mes valeurs
                }
            }
            $editedArray[$key+1]= $item ; //J'ajoute mon nouvel id de colonne à clef+1
        }
        return $editedArray;    //Retour du tableau modifié
    }


    /**
     * Creation de la requete sur biochemistry
     *
     * @param $bioCid
     * @return string
     */
    public function createRequestBio($bioCid){
        $request = " SELECT p.patient_id as Patient_ID, p.SUBJID, p.Sex as Sex,
                            CONCAT(c.Center_Acronym, ' - ', c.Center_City, ' - ', c.Center_Country) AS Center,
                            prot.Protocol_Name as Protocol, p.Class as Class, 
                            CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) as item, b.valeur as valeur " ;

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
                                                        AND b.Unite_Mesure_ID = u.Unite_Mesure_ID
                                                        and B.VALEUR > 0";

        $request .=" AND CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) in ".$this->createList($bioCid).
                    " AND p.Patient_ID in ".createList(Session::get('patientID'));

        return $request;
    }



    /**
     * Creation de la requete sur les genes
     *
     * @param $geneCid
     * @return string
     */
    public function createRequestGene($geneCid){
        $request = " SELECT p.Patient_ID, CONCAT(e.Gene_Symbol, ' (',e.Probe_ID, ') (', 
                                                                  a.SampleType_ID, '-', a.Technique_ID,'-',
                                                                  a.Molecule_ID, ') - ', cid.CID_Name,' - 1') as item, 
                            e.value1 as valeur
                     FROM experiments e, ea_analyse a, cids cid, cid_patient cp, patients p
                     WHERE cp.Patient_ID = p.Patient_ID
                     AND cp.CID_ID = cid.CID_ID
                     AND a.CID_ID = cp.CID_ID
                     AND a.Patient_ID = cp.Patient_ID
                     AND e.Analyse_ID = a.Analyse_ID
                     AND e.value1 > 0 ";
        $request.=" AND CONCAT(e.Gene_Symbol, ' (',e.Probe_ID, ') (', 
                                                                  a.SampleType_ID, '-', a.Technique_ID,'-',
                                                                  a.Molecule_ID, ') - ', cid.CID_Name,' - 1') in ".$this->createList($geneCid).
            " AND p.Patient_ID in ".createList(Session::get('patientID'));

        return $request;
    }



    /**
     * Genere un tableau contenant des valeurs au format :
     *              Nomenclature->NameN (UniteMesure->NameUM) - Cid->CID_Name
     * pour les entetes
     * @param $cids
     * @param $nomenclatures
     * @return array
     */
    public function createBioCidArray(){
        $patients = createList(Session::get('patientID'));

        $nomenclatures = DB::SELECT("SELECT b.biochemistry_ID as id
                  FROM biochemistry b
                  WHERE b.Valeur > 0
                  AND CONCAT(b.Nomenclature_ID,'-', b.Unite_Mesure_ID) in ".$this->createList(Session::get('biochemistryToView'))."
                  AND b.Patient_ID in ".$patients ." ORDER BY 1");
        $array = [];
        foreach ($nomenclatures as $item){
                    array_push($array, $item->id);
        }

        //Je ne garde que ceux qui ont bien des valeurs dans biochemistry
        $results = DB::SELECT("SELECT distinct CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) AS bioCid
                                    FROM biochemistry b, nomenclatures n, unite_mesure u, cids cid, cid_patient cp
                                    WHERE cp.CID_ID = cid.CID_ID
                                    AND b.CID_ID = cp.CID_ID
                                    AND b.Nomenclature_ID = n.Nomenclature_ID
                                    AND b.Unite_Mesure_ID = u.Unite_Mesure_ID 
                                    AND b.biochemistry_ID in ".createList($array)
                                 ." AND cid.CID_ID in".createList(Session::get('cidID'))
                                 ." 
                                 ORDER BY n.NameN ASC, u.NameUM ASC, cid.CID_ID ASC ");
        $return = [];
        foreach ($results as $result){
            if(isset($result->bioCid)){
                array_push($return, $result->bioCid);
            }
        }

        return $return;
    }








    /**
     * Genere un tableau avec gene_symbol(probe_id) - cid_name
     * pour les entetes
     *
     * @return array
     */
    public function getGeneCidArray(){
        $cids = Cid::whereIn('CID_ID', Session::get('cidID'))->orderBy('CID_ID', 'ASC')->get(['CID_Name']);
        $i =0;
        $request ="";

         if(Session::has('geneID')){

             foreach(Session::get('geneID') as $item){
                 if($i == 0){
                     $request.= " ( SELECT DISTINCT CONCAT(e.Gene_Symbol, ' (',e.Probe_ID,') ') as gene
                                    FROM experiments e
                                    WHERE e.Gene_Symbol = '". $item."' 
                                     AND e.Analyse_ID in ".createList(Session::get('analyseID'))."
                                     AND e.value1 > 0) ";

                     $i++;
                 }else{
                     $request.= " UNION ( SELECT DISTINCT CONCAT(e.Gene_Symbol, ' (',e.Probe_ID,') ') as gene
                                    FROM experiments e
                                    WHERE e.Gene_Symbol = '". $item."'
                                    AND e.Analyse_ID in ".createList(Session::get('analyseID'))."
                                    AND e.value1 > 0) ";
                 }
             }

             $genes = DB::SELECT($request . " ORDER BY 1");
             $array = [];
             foreach ($genes as $gene){
                 foreach ($cids as $meti){
                     array_push($array, $gene->gene.'- '.$meti->CID_Name);
                 }
             }


             //Je ne garde que les genes qui ont bien des valeurs dans experiments
             $results = DB::SELECT(" SELECT distinct CONCAT(e.Gene_Symbol, ' (',e.Probe_ID, ') (', 
                                                                  a.SampleType_ID, '-', a.Technique_ID,'-',
                                                                  a.Molecule_ID, ') - ', cid.CID_Name,' - 1') as geneCid
                                            FROM experiments e, ea_analyse a, cids cid, cid_patient cp
                                            WHERE a.Analyse_ID = e.Analyse_ID
                                            AND a.CID_ID = cp.CID_ID
                                            AND cp.CID_ID = cid.CID_ID
                                            AND e.value1 > 0
                                            AND CONCAT(e.Gene_Symbol, ' (',e.Probe_ID,') - ',cid.CID_Name) in ".$this->createList($array)."
                                            ORDER BY e.Gene_Symbol, e.Probe_ID, a.SampleType_ID, a.Technique_ID, a.Molecule_ID, cid.CID_ID 
                                            ");
             $return = [];
             foreach ($results as $result){
                 if(isset($result->geneCid)){
                     array_push($return, $result->geneCid);
                 }
             }

             return $return;
         }
    }


































    /**
     * Permet de generer une liste de string comprehensible pour
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





    /**
     * @param $input_array          Tableau de valeurs
     * @param $output_file_name     Nom de sortie
     * @param $delimiter            Delimiteur ";"
     * @param $bioHeader            Liste des BioCid pour l'entete
     * @param $keys                 Liste de SUBJID
     */
    function convert_to_csv($input_array, $output_file_name, $delimiter, $bioHeader, $keys){
        $temp_memory = fopen('php://memory', 'w');
        $fix = ['SUBJID','Sex','Center','Protocol','Class'];

        //Mise en place de la ligne des noms de colonnes
        $merge = array_merge($fix, $bioHeader);
        fputcsv($temp_memory, $merge, $delimiter);

        foreach ($keys as $key) {
            $array =[];
            foreach ($merge as $item){
                if(isset($input_array[$key][$item])) {
                    array_push($array, $input_array[$key][$item]);
                }else{
                    array_push($array,null);
                }
            }
            fputcsv($temp_memory, $array, $delimiter);
        }

        fseek($temp_memory, 0);

        // Modifie le header auformat csv
        header("Content-Type: application/csv;charset=UTF-8");
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        // sort le fichier pour etre telecharge
        fpassthru($temp_memory);
    }


}