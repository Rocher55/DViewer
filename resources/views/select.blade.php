@extends('layouts.template')

@section('content')

    <div class="container container-body">
        {!! Form::open(['url' => 'research/select', 'method' => 'post']) !!}
        <select data-placeholder="Choose something..." class="chosen-tag" multiple="true" name="select[]">
                <option value=""></option>
            @foreach($nomenclatures as $nomenclature)
                <option value="{!! $nomenclature->Nomenclature_ID !!}">{!! $nomenclature->NameN !!}</option>
            @endforeach
        </select>


                {!! Form::submit('Next', ['class' => 'next-button']) !!}
                {!! Form::close() !!}
    </div>
@endsection

