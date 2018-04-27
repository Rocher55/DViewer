@extends('layouts.template')

@section('content')

    <div class="container container-body  select">
        {!! Form::open(['url' => 'research/conditions', 'method' => 'post']) !!}
        <div class="row form-group conditions-row">
            <div class="col-md-3 text-center">
                {!! Form::label('protocol', 'Protocol')  !!}
                {!! Form::checkbox('protocol')!!}
            </div>
            <div class="col-md-3 text-center">
                {!! Form::label('center', 'Center')  !!}
                {!! Form::checkbox('center')!!}
            </div>
            <div class="col-md-3 text-center">
                {!! Form::label('cid', 'CID')  !!}
                {!! Form::checkbox('cid')!!}
            </div>
        </div>
        <div class="row form-group conditions-row">
            <div class="col-md-3 text-center">
                {!! Form::label('patient', 'Patient')  !!}
                {!! Form::checkbox('patient')!!}
            </div>
            <div class="col-md-3 text-center">
                {!! Form::label('food', 'Food-diaries')  !!}
                {!! Form::checkbox('food')!!}
            </div>
            <div class="col-md-3 text-center">
                {!! Form::label('biochemistry', 'Biochemistry')  !!}
                {!! Form::checkbox('biochemistry')!!}
            </div>
        </div>

        <div class="row form-group conditions-row">
            <div class="col-md-4 text-center">
                {!! Form::label('analyse', 'Analyse')  !!}
                {!! Form::checkbox('analyse')!!}
            </div>
            <div class="col-md-4 text-center">
                {!! Form::label('gene', 'Gene')  !!}
                {!! Form::checkbox('gene')!!}
            </div>
        </div>
        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection