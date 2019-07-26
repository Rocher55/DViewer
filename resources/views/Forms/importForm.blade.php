@extends('layouts.templateImport')

@section('importForm')


    @if(Session::has('flash_message'))
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert"></a>
             {!!Session::get('flash_message')!!}
        </div>
    @endif
    <p>This is the import page. Both XLSX (Excel) and CSV extension are allowed</p>
    <p>Only the first Excel sheet will be read</p>
    <p>CSV file are expected to use semicolon (';') as column separator, line break (CR LF, Windows default )as new line separator and dot ('.') as decimal separator </p>
    <p> This means that for now, you should avoid using ' ; ' , ' " ' and line break in your datas (cell)</p>
    <!--<p>This means that you should avoid using ';' as a regular data character. If you still need to use it though, you may escape it by using '\'
    (write '\;' instead of ';'). In addition to that, you may use doubles quotes (") to enclose a value (a cell). By doing that, you don't need to write "\;" to write ";".
    Beware of the character " as expoting it from Excel results in """</p>-->
    <p>There may be performance issues for large XLSX files. If that happens, try using CSV instead</p>

    <main-import></main-import>
    <wrapper-upload-component-patient up-url={{route('upload')}} down-url={{route('patientTemplate')}}>
        @csrf
    </wrapper-upload-component-patient>


@endsection
