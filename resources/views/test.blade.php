@extends('layouts.template')

@section('content')



    {!! var_dump(Session::get('protocolID')) !!}
    {!! var_dump(Session::get('centerID')) !!}
    {!! var_dump(Session::get('patientID')) !!}
    {!! var_dump(Session::get('cidID')) !!}





@endsection
