@extends('layouts.template')

@section('content')


        {{$request}}
        {!! var_dump($params) !!}
        {!! count(Session::get('patientID')) !!}
        {!! var_dump(Session::get('patientID')) !!}


@endsection
