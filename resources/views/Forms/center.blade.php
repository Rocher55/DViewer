@extends('layouts.template')

@section('content')

    <div class="container-body">
        {!! Form::open(['url' => 'research/center', 'method' => 'post']) !!}
        <select data-placeholder="Choose something..." class="chosen-tag" multiple="true" name="center[]">
            <option value=""></option>


                @foreach($centers as $center)
                        <option value="{!! $center->Center_ID !!}">{!! $center->Center_Acronym .' - '. $center->Center_City .' - '. $center->Center_Country !!}</option>
                @endforeach

        </select>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection

