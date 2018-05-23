@extends('layouts.template')

@section('content')


        {!! count($concerned) !!}
        {!! var_dump($concerned) !!}

        {!! var_dump(Session::get('patientID')) !!}


@endsection
