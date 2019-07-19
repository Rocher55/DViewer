<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Aspera\Spreadsheet\XLSX\Reader;
use Illuminate\Support\Facades\Storage;

//use Aspera\Spreadsheet\XLSX\SharedStringsConfiguration;

class ImportController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public  function  index(){
        return view('forms.importForm');
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
                $file=$this->convertXLSXtoCSV($file);
                $this->processFile($file,$fileType,$ids);
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



    public function  processFile($file,$filetype,$ids){

        switch ($filetype){
            case"patient":
                //check ids
                if (isset($ids)){
                    $ids =json_decode($ids,true);
                    if($ids['protocolID']==-1 or $ids['centerID']==-1){
                        Session::flash('flash_message',"Protocol or center has not been set. Please choose both and try again");
                        return redirect()->route('import');
                    }else{
                        //create decent csv(s)
                            //one for patients
                            //one for center_protocol

                        //save them somewhere

                        //into database
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

    public function convertXLSXtoCSV($file){

        //options used for XLSX-reader
        $options=array(
            'TempDir'=>env('TMP_DIRECTORY'),
            'SkipEmptyCells'             => false
        );
        $reader=new Reader($options);
        $reader->open($file);
        $reader->changeSheet(0);

        //crete empty file (actuelly contains line break)
        Storage::put('test.csv',"");

        //store a converted copy of XLSX  file under test.csv
        foreach ($reader as $row) {
            $i=0;
            $line="";
            for ($i=0;$i<sizeof($row);$i++){
                if(isset($row[$i+1])){
                    $line.=strval($row[$i]).",";
                }else{
                    Storage::append('test.csv',$line.strval($row[$i] ));
                }

            }

        }

        $test=Storage::get('test.csv');
        return $test;
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
}
