@extends('layouts.template')


@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/food', 'method' => 'post']) !!}

            <div class="row group">
                <div class="col-md-6 text-right">
                    {!! Form::label('161-from', 'Energy Intake (kJ/day)   From')  !!}
                    {!! Form::Number('161-from',null,['class' => 'input', 'step' => 'any']) !!}

                    {!! Form::label('161-to', 'To')  !!}
                    {!! Form::Number('161-to',null,['class' => 'input', 'step' => 'any']) !!}
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('165-from', 'Alcohol   From')  !!}
                    {!! Form::Number('165-from',null,['class' => 'input', 'step' => 'any']) !!}

                    {!! Form::label('165-to', 'To')  !!}
                    {!! Form::Number('165-to',null,['class' => 'input', 'step' => 'any']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="165-unite">

                    </select>
                </div>
            </div>



            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}

        {!! Form::close() !!}
    </div>
@endsection










