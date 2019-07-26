<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Aspera\Spreadsheet\XLSX\Reader;
use Illuminate\Support\Facades\Storage;
use splFileInfo;
use Illuminate\Support\Facades\DB;


//use Aspera\Spreadsheet\XLSX\SharedStringsConfiguration;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public  function  index(){
        return view('Forms.importForm');
    }



    public function upload(Request $request){
        $file=$request->file('csv');
        //dd($request->input('filetype'),$request->input('ids'));
        $fileType=$request->input('filetype');
        $ids=$request->input('ids');
        //regarder si le type d'import est précisé. ceci n'est pas une options que l'utilisateur devrait pouvoir changer. Cf vue
        if(!isset($fileType)){
            Session::flash('flash_message',"fileType not submitted. This is not supposed to happen.");
            return redirect()->route('import');
        }
        //regarder si un fichier a été soumis
        if (!isset($file)){
            Session::flash('flash_message',"no file submitted");
            return redirect()->route('import');
        }
        //regarder si le fichier est un csv
        if ($this->isCSV($file)){
            if ($file->getClientOriginalExtension()=='xlsx'){
                Session::flash('flash_message',"file uploaded successfully");
                //convertir le fichier xlsx en csv
                $file2=$this->convertXLSXtoCSV($file);

                $this->processFile($file2,$fileType,$ids,$file);



            } elseif ($file->getClientOriginalExtension()=='csv'){
                Session::flash('flash_message',"file uploaded successfully");
                $this->processFile($file,$fileType,$ids);
            }else{
                //si l'extension n'est pas CSV
                Session::flash('flash_message',"wrong extension detected, .csv or .xlsx expected");
                return redirect()->route('import');
            }
        }else{
            //si le fichier n'a pas le type mime d'un csv
            Session::flash('flash_message',"unauthorized MIME type (".$file->getMimeType()."), check if the file is a CSV, or try in another browser");
            return redirect()->route('import');
        }
        return redirect()->route('import')->withInput();
    }



    public function  processFile($file,$filetype,$ids,$file2=null){

        switch ($filetype){
            case"patient":
                //check ids
                if (isset($ids)){
                    $ids =json_decode($ids,true);
                    if($ids['protocolID']==-1 or $ids['centerID']==-1){
                        Session::flash('flash_message',"Protocol or center has not been set. Please choose both and try again");
                        return redirect()->route('import');
                    }else{
                        //check template
                        ini_set('auto_detect_line_endings',TRUE);
                        $handle = fopen($file->getPathname(),'r');
                        $headers=fgetcsv($handle,$length=0,$delimiter=';');
                        //check headers
                        if (
                            $headers[0]!=='SUBJID'
                            ||$headers[1]!=='SUBJINIT'
                            ||$headers[2]!=='Class'
                            ||$headers[3]!=='Sex'
                            ||$headers[4]!=='Age'
                            ||$headers[5]!=='Height (m)'
                            ||$headers[6]!=='Birth_Date'
                            ||$headers[7]!=='Race'
                            ||$headers[8]!=='Family_ID'
                            ||$headers[9]!=='Family_Structure'
                            ||$headers[10]!=='Female premenopausal'
                            ||$headers[11]!=='Female use Oral contraceptives'
                            ||$headers[12]!=='Type_Contraceptive'
                            ||$headers[13]!=='Mother urine pregnant'
                            ||$headers[14]!=='Parents eligible for inclusion'
                            ||$headers[15]!=='Eating disorder'
                            ||$headers[16]!=='Eating disorder comment'
                            ||$headers[17]!=='Alcohol or drug abuse'
                            ||$headers[18]!=='Drink alcohol'
                            ||$headers[19]!=='Alcohol(WK)'
                            ||$headers[20]!=='Concomitant condition'
                            ||$headers[21]!=='Cigarettes-Pipes/year'
                            ||$headers[22]!=='EER'
                        ){
                            Session::flash('flash_message',"Wrong header detected. Please make sure to use the template provided.");
                            return Redirect::back()->withInput(Input::all());
                        }
                        //check subjid
                        $i=0;
                        while ( ($data = fgetcsv($handle,$length=0,$delimiter=';') ) !== FALSE ) {
                            $i=$i+1;
                            if(empty($data[0])){
                                Session::flash('flash_message',"empty subjid detected at line ".$i." . Please fill this field" );
                                return Redirect::back();
                            }
                            if(empty($data[3])){
                                Session::flash('flash_message',"empty sex detected at line ".$i." . Please fill this field" );
                                return Redirect::back();
                            }

                        }

                        fclose($handle);

                        //create decent csv
                        $handle = fopen($file->getPathname(),'r');
                        $handleWrite=fopen($file->getPath().'/temporaryFileUsedForCSVWriting.csv','w');
                        $headers=fgetcsv($handle,$length=0,$delimiter=';');
                        $numberOfActualRowsOfData=0;
                        while ( ($data = fgetcsv($handle,$length=0,$delimiter=';') ) !== FALSE ) {
                            //array_unshift($data,null);
                            array_splice($data,2,0,$ids['centerID']);
                            array_splice($data,3,0,$ids['protocolID']);
                            foreach ($data as $key=>$item) {

                                if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $item)) {
                                    $array = explode('/', $item);
                                    $data[$key]= $array[2] . "-" . $array[1] . "-" . $array[0];
                                }
                            }
                            fputcsv($handleWrite,$data,$delimiter=';');
                            $numberOfActualRowsOfData+=1;
                        }
                        $realHeaders=$headers;
                        //array_unshift($realHeaders,'Patient_ID');
                        array_splice($realHeaders,2,0,'Center_ID');
                        array_splice($realHeaders,3,0,'Protocol_ID');

                        $pdostring=env('DB_CONNECTION').':host='.env('DB_HOST').';port='.env('DB_PORT').';dbname='.env('DB_DATABASE');

                        try {
                            $dbh = new \PDO($pdostring, env('DB_USERNAME'), env('DB_PASSWORD'));
                            $dbh->beginTransaction();
                        }catch (\PDOException $e){
                            dd($e);
                        }

                        $query=$this->loadData(addslashes($file->getPath().'/temporaryFileUsedForCSVWriting.csv'),'patients',$realHeaders,$dbh);
                        //$this->bulkInsert($file->getPath().'/temporaryFileUsedForCSVWriting.csv','patients',$realHeaders,$numberOfActualRowsOfData,100);

                        try {

                            $res=$dbh->exec('INSERT IGNORE into center_protocol(Center_ID,Protocol_ID) values ('.$ids['centerID'].','.$ids['protocolID'].');');
                            if($res===false){

                                $dbh->rollBack();

                                Session::flash('flash_message',"Import failed :".$dbh->errorInfo()[2]." \r\n Could not create dynamic link between center and protocol.");
                                return redirect()->route('import');
                                dd($dbh->errorInfo(),$query);
                            }
                        }catch (\PDOException $e){

                            $dbh->rollBack();

                            dd($e,$query);
                        }

                        try {

                            $res=$dbh->exec($query);
                            if($res===false){

                                $dbh->rollBack();

                                Session::flash('flash_message',"Import failed :".$dbh->errorInfo()[2]." \r\n If duplicate entry is reported, make sure that the patient identified by the three".
                                    " first number reported was not previously imported for the same protocol and center.");
                                return redirect()->route('import');
                                dd($dbh->errorInfo(),$query);
                            }
                        }catch (\PDOException $e){

                            $dbh->rollBack();

                            dd($e,$query);
                        }

                        $dbh->commit();
                        DB::beginTransaction();

                        $binaryHandle=fopen($file->getPathname(),'rb');
                        $binaryHandleTempFile=fopen($file->getPath().'/temporaryFileUsedForCSVWriting.csv','rb');
                        if (isset($file2)){
                            $originalName=$file2->getClientOriginalName();
                        }else{
                            $originalName=$file->getClientOriginalName();
                        }
                        try {
                            //original file
                            DB::table('history')->insert(array(
                                'name' => $originalName,
                                'file' => fread($binaryHandle,filesize($file->getPathname())),
                                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                                "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                            ));
                            //created temporary file corresponding to patient table (without Primary key)
                            DB::table('history')->insert(array(
                                'name' => 'automatically_generated_file_for_patient',
                                'file' => fread($binaryHandleTempFile,filesize($file->getPath().'/temporaryFileUsedForCSVWriting.csv')),
                                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                                "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                            ));


                            DB::commit();
                            // all good
                        } catch (\Exception $e) {
                            DB::rollback();
                            // something went wrong
                            dd($e);
                        }





                        fclose($handle);
                        fclose($handleWrite);
                        fclose($binaryHandle);
                        fclose($binaryHandleTempFile);

                        ini_set('auto_detect_line_endings',FALSE);


                    }
                }else{
                    Session::flash('flash_message',"no ids detected. this should not happen");
                    return redirect()->route('import');
                }
                $ids=null;
                break;
            default:
                Session::flash('flash_message',"unknown filetype. This should not happen.");
                return redirect()->route('import');
                break;


        }
    }




    private function BulkInsert($filePath,$table_name,$columnNames,$numberOfRowsLeftToProcess,$numberOfLinesPerInsert,$enableTransaction=true){
        $pdostring=env('DB_CONNECTION').':host='.env('DB_HOST').';port='.env('DB_PORT').';dbname='.env('DB_DATABASE');

        try {
            $dbh = new \PDO($pdostring, env('DB_USERNAME'), env('DB_PASSWORD'));
        }catch (\PDOException $e){
            dd('Wrong PDO configuration',$e);
        }
        $arrayToString=createBackQuotedList($columnNames);
        $questionMarkString=$this->createPrepareStatementValues($columnNames,$numberOfLinesPerInsert);

        $CSVHandle = fopen($filePath, 'r');


        if ($numberOfRowsLeftToProcess>$numberOfLinesPerInsert){
            try {

                $pdoStatement = $dbh->prepare('INSERT INTO ' . $table_name . $arrayToString . 'VALUES ' . $questionMarkString);


                if($pdoStatement===false){
                    dd($dbh->errorInfo());
                }
            }catch(\PDOException $e) {
                dd($e);
            }
        }
        if ($enableTransaction){
            try {

                $dbh->beginTransaction();

                if($dbh===false){
                    dd($dbh->errorInfo());
                }
            }catch(\PDOException $e) {
                dd($e);
            }
        }
        while($numberOfRowsLeftToProcess>$numberOfLinesPerInsert){
            try {

                $pdoStatement->execute($this->extractFromCSVToPDO($numberOfRowsLeftToProcess,$CSVHandle));


                if($pdoStatement===false){
                    if($enableTransaction){
                        $dbh->rollBack();
                    }

                    dd($dbh->errorInfo());
                }
            }catch(\PDOException $e) {
                if($enableTransaction){
                    $dbh->rollBack();
                }
                dd($e);
            }
            $numberOfRowsLeftToProcess-=$numberOfLinesPerInsert;
        }
        //traiter ce qu'il reste
        try {
            $questionMarkString=$this->createPrepareStatementValues($columnNames,$numberOfRowsLeftToProcess);
            $pdoStatement = $dbh->prepare('INSERT INTO ' . $table_name . $arrayToString . 'VALUES ' . $questionMarkString);
            $debugvar=$this->extractFromCSVToPDO($numberOfRowsLeftToProcess,$CSVHandle);

            $pdoStatement->execute($debugvar);
            dd($debugvar,$pdoStatement);

            if($pdoStatement===false){
                if($enableTransaction){
                    $dbh->rollBack();
                }

                dd($dbh->errorInfo());
            }
        }catch(\PDOException $e) {
            if($enableTransaction){
                $dbh->rollBack();
            }
            dd($e);
        }

        if($enableTransaction){
            $dbh->commit();
        }




        /* $query="INSERT INTO ".$table_name." ".$arrayToString." VALUES ".$darkOne;*/



        /*
                try {
                    $dbh = new \PDO($pdostring, env('DB_USERNAME'), env('DB_PASSWORD'));
                    $res=$dbh->exec($query);
                    if($res==false){
                        dd($dbh->errorInfo(),$query);
                    }
                }catch (\PDOException $e){
                    dd($e,$query);
                }
        */       fclose($CSVHandle);
        dd('end of the line',$pdoStatement->rowCount());

        /*


        */

    }
    public function extractFromCSVToPDO($numberOfRowsToProcess,$CSVHandle)
    {

        $i = 0;
        $return=[];
        while (($data = fgetcsv($CSVHandle, $length = 0, $delimiter = ';')) !== FALSE && $i<$numberOfRowsToProcess) {
            $return=array_merge($return,$data);
            $i+=1;
        }
        return $return;



    }
    public function createPrepareStatementValues($numberOfValuesInOneRow,$numberOfLinesPerInsert){

        $questionMarkString=" ( ";
        $return="";
        foreach ($numberOfValuesInOneRow as $item){
            $questionMarkString .= "?, ";
        }
        $questionMarkString = substr($questionMarkString, 0, -2) ." ) ";

        for ($x=0;$x<$numberOfLinesPerInsert;$x++) {
            $return .= $questionMarkString.", ";
        }
        $return = substr($return, 0, -2) .";";


        return $return;

    }


    public function convertXLSXtoCSV($file){

        //options used for XLSX-reader
        $options=array(
            'TempDir'=>env('TMP_DIRECTORY'),
            'SkipEmptyCells'             => false,
            'ForceDateFormat'=> 'd/m/Y'
        );
        $reader=new Reader($options);
        $reader->open($file);
        $reader->changeSheet(0);

        //crete empty file (actuelly contains line break)
        Storage::put('test.csv',null);

        //store a converted copy of XLSX  file under test.csv
        $futureFile="";
        foreach ($reader as $row) {
            $i=0;
            for ($i=0;$i<sizeof($row);$i++){
                if(isset($row[$i+1])){
                    $futureFile.=strval($row[$i]).";";
                }else{
                    $futureFile.=strval($row[$i])."\r\n";
                    //Storage::append('test.csv',$line.strval($row[$i] ));
                }

            }

        }
        Storage::put('test.csv',$futureFile);
        $info = new SplFileInfo(storage_path('app/test.csv'));

        return $info;
    }

    public function isCSV( $file )
    {
        //allowed mime type, do not hesitate to add your own.
        $csv_mime_types = [
            'text/csv',
            'text/plain',
            'application/csv',
            'text/comma-separated-values',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
            'text/anytext',
            'application/octet-stream',
            'application/txt',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        $mime_type = $file->getMimeType();

        return in_array( $mime_type, $csv_mime_types );
    }

    private function loadData($filePath,$table_name,$columnNames,$pdo){


        $varList=$this->createVarList(count($columnNames));
        $arrayToString=createBackQuotedList($columnNames);
        $SetListForLoadData=$this->createSetListForLoadData($columnNames);

        $query="LOAD DATA ".
            "LOW_PRIORITY ".
            "INFILE '".$filePath.
            "'  ".
            "INTO TABLE ".$table_name.

            " FIELDS ".
            "TERMINATED BY ';' ".
            "ESCAPED BY '\\\\' ".
            " ENCLOSED BY '' ".

            " LINES ".
            "TERMINATED BY '\\n' ".
            $varList.
            "SET ".
            $SetListForLoadData.
            ";";

        return $query;

    }

    public function createVarList($numberOfVariables){
        $varList='( ';
        for($x=0;$x<$numberOfVariables;$x++){
            $varList .= "@v".$x.", ";
        }
        return substr($varList, 0, -2) ." ) ";
    }
    public function makeAGoddamnSQLStringValue($array){
        $return=" ( ";
        foreach ($array as $item){
            if(is_numeric($item)) {
                $return .= $item . " ,";
            }elseif(empty($item)){
                $return .=  "null ,";
            }elseif(preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $item)){
                $array=explode('/',$item);
                $return.="'".$array[2]."-".$array[1]."-".$array[0]."' ,";
            }else{
                $return.="'".$item."' ,";
            }
        }
        $return = substr($return, 0, -1) ." ) ";

        return $return;
    }
    public function  createSetListForLoadData($columNames){
        $result="";
        foreach ($columNames as $key=>$columnName){
            $result=$result."`".$columnName."` = nullif(@v".$key.",''), ";
        }
        return substr($result, 0, -2) ;
        // SUBJID = nullif(@v1,''),
    }
}
