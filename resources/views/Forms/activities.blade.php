@extends('layouts.template')


@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/activities', 'method' => 'post', 'id'=>'form']) !!}

        <div class="row">
            <div class="col-md-5 text-right">
                {!! Form::label('index', 'Baecke Index')  !!}
                {!! Form::checkbox('index','Baecke index total', false); !!}
            </div>
            <div class="col-md-4 text-right">
                {!! Form::label('leisure', 'Baecke Leisure')  !!}
                {!! Form::checkbox('leisure','Baecke Leisure', false); !!}
            </div>

        </div>

        <div class="row">
            <div class="col-md-5 text-right">

            </div>
            <div class="col-md-4 text-right">
                    {!! Form::label('work', 'Baecke Work')  !!}
                    {!! Form::checkbox('work','Baecke Work', false); !!}
            </div>

        </div>

        <div class="row">
            <div class="col-md-5 text-right">

            </div>
            <div class="col-md-4 text-right">
                {!! Form::label('sport', 'Baecke Sport')  !!}
                {!! Form::checkbox('sport','Baecke Sport', false); !!}
            </div>
        </div>




        <div class="container ">
            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
            {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        </div>
    {!! Form::close() !!}
    </div>
@endsection










