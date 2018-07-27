@extends('layouts.template')

@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/center', 'method' => 'post', 'id'=>'form']) !!}
        <select data-placeholder="Choose the center(s) ..." class="chosen-tag" multiple="true" name="center[]">
            <option value=""></option>


                @foreach($centers as $center)
                        <option value="{!! $center->Center_ID !!}">{!! $center->Center_Acronym .' - '. $center->Center_City .' - '. $center->Center_Country !!}</option>
                @endforeach

        </select>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
            {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection

