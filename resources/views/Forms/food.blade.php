@extends('layouts.template')



@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/cid', 'method' => 'post']) !!}

            <div class="row">
                <div class="col-md-5 col-md-offset-2">

                </div>
                <div class="col-md-5">

                </div>
            </div>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>




@endsection