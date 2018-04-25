@extends('layouts.template')

@section('content')
    <div class="container buttons-group" >
        <a type="button" class="button btn button-success  btn-lg col-md-4 col-md-offset-1"  href="{{ URL::to('/research/select')}}">Search</a>
        <a type="button" class="button btn button-info  btn-lg col-md-4 col-md-offset-2" href="{{ URL::to('/import')}}">Import</a>
    </div>
@endsection
