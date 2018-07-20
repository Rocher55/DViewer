@extends('layouts.template')

@section('content')
    <div class="specifications">
        <h2>{!! Parsedown::instance()->line($specification->Title) !!}</h2>
        <br>
        <div class="col-md-6">

            <figure>
                <img src="data:image/{{$specification->Image_Extension}};base64,{{base64_encode($specification->Image)}}" />
            </figure>
        </div>
        <div class="col-md-6">

            <div class="specifications-body">
                {!! Parsedown::instance()->text($specification->Body) !!}
            </div>
            <div class="references">
                {!! Parsedown::instance()->text($specification->References) !!}
            </div>
        </div>

    </div>
@endsection