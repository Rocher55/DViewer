<?php


namespace App\Http\Controllers;


use App\Physical_activities;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Cid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResultController extends Controller{

    private $biochemistryID = array();
    private $experimentsID = array();
    private $foodDiariesID = array();
    private $activitiesID = array();

    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if(!isset($_SERVER['HTTP_REFERER'])){
            return redirect()->route('home');
        }


        womanPercentage();
        $previousPath = str_replace(url('/'), '', url()->previous());

        //Si je n'ai pas colonnes, clefs et la tableau en session OU que la page précédente est "/research/select-gene/"
        //alors je recupere les donnees
        if(!Session::has('results-columns') and !Session::has('results-keys') and !Session::has('results-array')
            or $previousPath == '/research/select-gene') {
            //Tableau contenant les valeurs
            $array = array();

            //Base




            //bioCid
            $bioCid = $this->createBioCidArray();
            $requestBio = $this->createRequestBio();
            //Execution de la requete
            $resultsBio = DB::SELECT($requestBio);
            //Pour chaque resultat le mettre dans
            //le tableau à l'indice 1 : Patient_ID
            //et 2 : item
            foreach ($resultsBio as $item) {
                $array[strval($item->Patient_ID)][$item->item] = $item->valeur;
            }


            //Recuperation des donnees de food_diaries
            $foodWeek = array();
            if(Session::has('foodToView')){
                //foodWeek
                $foodWeek = $this->createFoodWeekArray();
                $requestFood = $this->createRequestFood();
                $resultsFood = DB::SELECT($requestFood);
                //Pour chaque resultat le mettre dans
                //le tableau à l'indice 1 : Patient_ID
                //et 2 : item
                foreach ($resultsFood as $item){
                    $array[strval($item->Patient_ID)][$item->item] = $item->valeur;
                }
            }

            //Recuperation des donnees de physical_activities
            $activitiesCID = array();
            if(Session::has('activitiesToView')){
                $activitiesCID = $this->createActivitiesCidArray();
                $requestActivities = $this->createRequestActivities();
                $resultsActivities = DB::SELECT($requestActivities);
                //Pour chaque resultat le mettre dans
                //le tableau à l'indice 1 : Patient_ID
                //et 2 : item
                foreach ($resultsActivities as $result){
                    foreach ($activitiesCID as $item){
                        $columns = explode('-',$item);
                        $column = str_replace(' ','',$columns[0]);
                        if(trim($columns[1])==$result->CID_Name){
                            $array[strval($result->Patient_ID)][$item] = $result->$column;
                        }

                    }

                }
            }

            //geneCid
            $geneCid = array();
            $newCols = array();
            //S'il ya des genes que je souhaite voir et que des analyses existent
            if (Session::has('geneID') && count(Session::get('analyseID'))) {
                //Recuperation des genes au format
                //PCYT1A (A_24_P106057) (3-7-2) - CID2 - 1
                //Gene_Symbol (Probe_ID) (SampleType_ID-Technique_ID-Molecule_ID) - CID_Name - indice
                $geneCid = $this->getGeneCidArray();

                if(count($this->experimentsID)>0){
                    //Creation et execution de la requete
                    $requestGene = $this->createRequestGene();
                    $resultsGene = DB::SELECT($requestGene);

                    //Pour chaque resultat
                    foreach ($resultsGene as $item) {
                        //Si une valeur exite a cet endroit alors
                        if (isset($array[strval($item->Patient_ID)][$item->item])) {
                            $i = 2;   //indice = 2

                            //Je cree le nom que portera la colonne
                            $newCol = substr_replace($item->item, $i, -1, 1);

                            //Et temps que j'ai un resultat pour la nouvelle colonne
                            //Incrementer i et changer le nom de la colonne en fonction
                            while (isset($array[strval($item->Patient_ID)][$newCol])) {
                                $i++;
                                $newCol = substr_replace($item->item, $i, -1, 1);
                            }
                            //J'ajoute dans mon tableau des nouvelles colonnes la colonne
                            //ainsi que la valeur pour le patient dans la nouvelle colonne
                            $newCols[] = $newCol;
                            $array[strval($item->Patient_ID)][$newCol] = $item->valeur;
                        } else {
                            //Sinon j'ajoute simplement la valeur dans le tableau
                            $array[strval($item->Patient_ID)][$item->item] = $item->valeur;
                        }
                        //Je garde le nom des colonnes en un exemplaire
                        $newCols = array_unique($newCols);
                    }
                    //Si mon tableau de nouvelles colonnes existe alors je reorganise
                    //mon tableau d'entete : geneCid
                    if (isset($newCols)) {
                        $geneCid = $this->reorganizeArray($geneCid, $newCols);
                    }
                }

            }


            $base = $this->createBase(array_keys($array));
            foreach ($base as $item){
                $array[strval($item->Patient_ID)]['SUBJID'] = $item->SUBJID;
                $array[strval($item->Patient_ID)]['Sex'] = $item->Sex;
                $array[strval($item->Patient_ID)]['Center'] = $item->Center;
                $array[strval($item->Patient_ID)]['Protocol'] = $item->Protocol;
                $array[strval($item->Patient_ID)]['Class'] = $item->Class;
            }


            $keys = array_keys($array);              //Recuperation des cles (Patient_ID)
            $cols = array_merge($bioCid, $foodWeek,$activitiesCID, $geneCid);  //Fusion des nom de colonnes entre Biochemistry et Genes
            $this->sendToSession($array, $keys, $cols);//Ajout du tableau de valeur, des clefs et colonnes en Session
        }else{
            $keys = Session::get('results-keys');
            $cols = Session::get('results-columns');
            $array = Session::get('results-array');
        }

        //Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 50;
        $path = LengthAwarePaginator::resolveCurrentPath();
        $keys = new LengthAwarePaginator(array_slice($keys, $perPage * ($currentPage - 1), $perPage), count($keys), $perPage, $currentPage, ['path' => $path]);

       return view('results', compact('array', 'cols', 'keys'));
    }


    /**
     * Permet de creer la partie fixe du resultat
     *
     * @return array
     */
    public function createBase($patient_ids){
        $request = "SELECT  p.Patient_ID, p.SUBJID, CASE WHEN p.Sex =1 THEN 'M' ELSE 'F' END as Sex,
                            CONCAT(c.Center_Acronym, ' - ', c.Center_City, ' - ', c.Center_Country) AS Center,
                            prot.Protocol_Name as Protocol, p.Class as Class
                    FROM patients p, centers c, protocols prot, center_protocol cp
                    WHERE prot.protocol_id = cp.protocol_id
                    AND cp.protocol_id = p.protocol_id
                    AND p.center_id = cp.center_id
                    AND cp.center_id = c.center_id
                    AND p.patient_id in".createList($patient_ids).
                  "GROUP BY 1 ORDER BY p.Patient_ID asc
                  ";
        $result = DB::select($request);

        return $result;
    }


    /**
     * Creation de la requete sur biochemistry
     *
     * @param $bioCid
     * @return string
     */
    public function createRequestBio(){
        $request = " SELECT p.patient_id as Patient_ID, 
                            CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) as item, b.value as valeur 
                     FROM  patients p, cid_patient cp, cids cid, biochemistry b, nomenclatures n, unite_mesure u
                     WHERE cp.CID_ID = cid.CID_ID
                     AND cp.Patient_ID = p.Patient_ID
                     AND b.CID_ID = cp.CID_ID
                     AND b.Patient_ID = cp.Patient_ID
                     AND b.Nomenclature_ID = n.Nomenclature_ID
                     AND b.Unite_Mesure_ID = u.Unite_Mesure_ID";
        $request .=" AND b.Biochemistry_ID in ".createStringList($this->biochemistryID);

        return $request;
    }

    /**
     * Creation de la requete sur food_diaries
     *
     * @return string
     */
    public function createRequestFood(){
        $request = " SELECT p.Patient_ID as Patient_ID, CONCAT(n.NameN,' (',u.NameUM ,') - ', w.WK_NAME) as item, f.value as valeur
                     FROM food_diaries f, patient_week pw, weeks w, nomenclatures n, unite_mesure u, patients p
                     WHERE f.WK_ID = pw.WK_ID
                     AND pw.WK_ID = w.WK_ID
                     AND f.Patient_ID = pw.Patient_ID
                     AND pw.Patient_ID = p.Patient_ID
                     AND f.Nomenclature_ID = n.Nomenclature_ID
                     AND f.unite_mesure_id = u.unite_mesure_id";
        $request .= " AND f.food_diaries_id in".createStringList($this->foodDiariesID)
                    ." ORDER BY p.Patient_ID ";

        return $request;
    }

    /**
     * Creation de la requete sur l'activité physique
     *
     * @return string
     */
    public function createRequestActivities(){
        $select ="";
        $and ="";
        foreach(Session::get('activitiesToView') as $activity){
            $select.=", `pa`.`".$activity."` as '".str_replace(' ','',$activity)."'";
            //$and .= " AND `pa`.`".$activity."` is not null";
        }
        $request = " SELECT p.Patient_ID , cid.CID_Name ".$select.
                   " FROM physical_activities pa, cid_patient cp, cids cid, patients p
                     WHERE pa.CID_ID = cp.CID_ID
                     AND cp.CID_ID = cid.CID_ID
                     AND pa.Patient_ID = cp.Patient_ID
                     AND cp.Patient_ID= p.Patient_ID
                     AND pa.Physical_Activities_ID in ".createList($this->activitiesID).
                    $and;

        return $request;
    }

    /**
     * Creation de la requete sur les genes
     *
     * @param $geneCid
     * @return string
     */
    public function createRequestGene(){
        $request = " SELECT p.Patient_ID, CONCAT(g.Gene_Symbol, ' (',g.Probe_ID, ') (', 
                                                                      s.SampleType_Name, '-', t.Technical_Name,'-',
                                                                      m.Molecule_Name, ') - ', cid.CID_Name,' - 1') as item, 
                            e.value1 as valeur
                     FROM experiments e, ea_analyse a, cids cid, cid_patient cp, patients p, genes g
                     , molecules m, sampletypes s, techniques t
                     WHERE cp.Patient_ID = p.Patient_ID
                     AND cp.CID_ID = cid.CID_ID
                     AND a.CID_ID = cp.CID_ID
                     AND a.Patient_ID = cp.Patient_ID
                     AND e.Analyse_ID = a.Analyse_ID 
                     AND e.Gene_ID = g.Gene_ID 
                     
                     AND m.Molecule_ID = a.Molecule_ID
                     AND s.SampleType_ID = a.SampleType_ID
                     AND t.Technique_ID = a.Technique_ID";
        $request.=" AND e.Experiments_ID in ".createList($this->experimentsID)."
                    ORDER BY p.Patient_ID";

        return $request;
    }








    /**
     * Genere un tableau contenant des valeurs au format :
     *              Nomenclature->NameN (UniteMesure->NameUM) - Cid->CID_Name
     * pour les entetes
     * @return array
     */
    public function createBioCidArray(){
        $patients = createList(Session::get('patientID'));
        $biochemistry_ID = DB::SELECT("SELECT b.biochemistry_ID as id
                                             FROM biochemistry b
                                             WHERE CONCAT(b.Nomenclature_ID,'-', b.Unite_Mesure_ID) in ".createStringList(Session::get('biochemistryToView'))."
                                             AND b.Patient_ID in ".$patients ." ORDER BY b.Patient_ID");

        $this->biochemistryID = createArray($biochemistry_ID,'id');;

        //Je ne garde que ceux qui ont bien des valeurs dans biochemistry
        $results = DB::SELECT("SELECT distinct CONCAT(n.NameN,' (',u.NameUM ,') - ', cid.CID_NAME) AS bioCid
                                    FROM biochemistry b, nomenclatures n, unite_mesure u, cids cid, cid_patient cp
                                    WHERE cp.CID_ID = cid.CID_ID
                                    AND b.CID_ID = cp.CID_ID
                                    AND b.Nomenclature_ID = n.Nomenclature_ID
                                    AND b.Unite_Mesure_ID = u.Unite_Mesure_ID 
                                    AND b.biochemistry_ID in ".createList($this->biochemistryID)
                                 ." AND cid.CID_ID in".createList(Session::get('cidID'))
                                 ." ORDER BY n.NameN ASC, u.NameUM ASC, cid.CID_ID ASC ");
        $return = createArray($results,'bioCid');

        return $return;
    }

    /**
     * Genere un tableau contenant des valeurs au format :
     *              Nomenclature->NameN (UniteMesure->NameUM) - Weeks->Wk_Name
     * pour les entetes
     *
     * @return string
     */
    public function createFoodWeekArray(){
        $patients = createList(Session::get('patientID'));
        $food_ID = DB::SELECT("SELECT f.food_diaries_id as id 
                                      FROM food_diaries f 
                                      WHERE CONCAT(f.Nomenclature_ID,'-', f.Unite_Mesure_ID) in ".createStringList(Session::get('foodToView'))."
                                      AND f.Patient_ID in ".$patients ." ORDER BY f.Patient_ID");

        $this->foodDiariesID = createArray($food_ID, 'id');
        //Je ne garde que ceux qui ont bien des valeurs dans food_diaries
        $results = DB::SELECT("SELECT distinct CONCAT(n.NameN,' (',u.NameUM ,') - ', w.WK_NAME) AS foodWeek
                                    FROM food_diaries f, nomenclatures n, unite_mesure u, weeks w, patient_week pw
                                    WHERE pw.WK_ID = w.WK_ID
                                    AND f.WK_ID = pw.WK_ID
                                    AND f.Nomenclature_ID = n.Nomenclature_ID
                                    AND f.Unite_Mesure_ID = u.Unite_Mesure_ID 
                                    AND f.value is not null 
                                    AND f.food_diaries_ID in ".createList($this->foodDiariesID)
                                 ." ORDER BY n.NameN ASC, u.NameUM ASC, w.WK_ID ASC ");
        $return = createArray($results,'foodWeek');

        return $return;
    }

    /**
     * Recupere les id de physical_activities des patients et cid correspondants
     */
    public function createActivitiesCidArray(){
        $activities_ID = DB::select('SELECT pa.Physical_Activities_ID as id
                                            FROM physical_activities pa
                                            WHERE pa.Patient_ID in'.createList(Session::get('patientID')).'
                                            AND pa.CID_ID in'.createList(Session::get('cidID')).'
                                            ORDER BY pa.Patient_ID');

        $this->activitiesID = createArray($activities_ID, 'id');
        //$paCid = Physical_activities::wehereIn('Physical_Activities_ID', $this->activitiesID)->distinct();
        $activitiesCid = array();
        $cids = Cid::distinct()->whereIn('CID_ID', Session::get('cidID'))->get();
        foreach (Session::get('activitiesToView') as $activity){
            foreach ($cids as $cid){
                $exist = Physical_activities::whereIn('Physical_Activities_ID', $this->activitiesID)
                                                ->where('CID_ID', $cid->CID_ID  )
                                                ->count($activity);
                if($exist >0){
                    array_push($activitiesCid, $activity.' - '.$cid->CID_Name);
                }
            }
        }

        return $activitiesCid;
    }

    /**
     * Genere un tableau avec gene_symbol(probe_id) - cid_name
     * pour les entetes
     *
     * @return array
     */
    public function getGeneCidArray(){
            $request = " SELECT e.Experiments_ID as id
                         FROM experiments e, ea_analyse a
                         WHERE e.Analyse_ID = a.Analyse_ID
                         AND e.Gene_ID in ".createList(Session::get('geneID'))."                        
                         AND e.Analyse_ID in ".createList(Session::get('analyseID'));

            $experiments_ID = DB::SELECT($request);
            $array = createArray($experiments_ID, 'id');
            $this->experimentsID = $array;

        if(count($this->experimentsID)>0) {
            //Je ne garde que les genes qui ont bien des valeurs dans experiments
            $results = DB::SELECT(" SELECT distinct CONCAT(g.Gene_Symbol, ' (',g.Probe_ID, ') (', 
                                                                      s.SampleType_Name, '-', t.Technical_Name,'-',
                                                                      m.Molecule_Name, ') - ', cid.CID_Name,' - 1') as geneCid
                                                FROM experiments e, ea_analyse a, cids cid, cid_patient cp, genes g
                                                  , molecules m, sampletypes s, techniques t
                                                WHERE a.Analyse_ID = e.Analyse_ID
                                                AND a.CID_ID = cp.CID_ID
                                                AND cp.CID_ID = cid.CID_ID
                                                AND e.Gene_ID = g.Gene_ID
                                                
                                                AND m.Molecule_ID = a.Molecule_ID
                                                AND s.SampleType_ID = a.SampleType_ID
                                                AND t.Technique_ID = a.Technique_ID
                                                
                                                AND e.Experiments_ID in " . createList($array) . "
                                                ORDER BY g.Gene_Symbol, g.Probe_ID, a.SampleType_ID, a.Technique_ID, a.Molecule_ID, cid.CID_ID ");

            $return = createArray($results, 'geneCid');
        }else{
            $return=array();
        }
            return $return;
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