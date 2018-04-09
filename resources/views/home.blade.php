<<<<<<< HEAD
@extends('layouts.template')

@section('content')
    <div class="container buttons-group" >
        <a type="button" class="button btn button-success  btn-lg col-md-4 col-md-offset-1"  href="{{ URL::to('/research/select')}}">Search</a>
        <a type="button" class="button btn button-info  btn-lg col-md-4 col-md-offset-2" href="{{ URL::to('/import')}}">Import</a>
    </div>
=======
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
>>>>>>> master
@endsection
