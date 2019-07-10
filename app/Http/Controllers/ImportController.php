<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        //dd($file->getClientOriginalExtension());
        //regarder si le fichier est un csv
        if ($this->isCSV($file)){
            if ($file->getClientOriginalExtension()=='xlsx'){
                Session::flash('flash_message',"got ur file pal");
            } elseif ($file->getClientOriginalExtension()=='csv'){
                Session::flash('flash_message',"got ur file pal");
            }else{
                //si l'extension n'est pas CSV
                Session::flash('flash_message',"unauthorized MIME type, check if the file is a CSV, or try in another browser");
                return redirect()->route('import');
            }
        }else{
            //si le fichier n'a pas le type mime d'un csv
            Session::flash('flash_message',"unauthorized MIME type, check if the file is a CSV, or try in another browser");
            return redirect()->route('import');
        }




        return redirect()->route('import')->withInput();
        }



    public function isCSV( $file )
    {
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
        ];

        $mime_type = $file->getMimeType();

        return in_array( $mime_type, $csv_mime_types );
    }
}
