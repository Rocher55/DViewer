@extends('layouts.template')

@section('content')



        {!! var_dump(Session::get('cidID')) !!}
        {!! var_dump(Session::get('patientID')) !!}
@endsection
