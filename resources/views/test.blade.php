@extends('layouts.template')

@section('content')

    {!! $request !!}
    {!! var_dump($bioCid) !!}

    {!! var_dump(Session::get('geneID')) !!}
    {!! var_dump(Session::get('cidID')) !!}

    {!! var_dump(Session::get('biochemistryToView')) !!}







@endsection
