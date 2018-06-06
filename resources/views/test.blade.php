@extends('layouts.template')

@section('content')


    {!! var_dump($bioCid) !!}
    {!! $request !!}
    {!! var_dump(Session::get('geneID')) !!}
    {!! var_dump(Session::get('cidID')) !!}
    {!! var_dump(Session::get('biochemistryToView')) !!}







@endsection
