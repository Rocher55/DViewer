@extends('layouts.template')


@section('content')
    <div class="container-big-body">
        {!! Form::open(['url' => 'research/food', 'method' => 'post', 'id'=>'form']) !!}
            @foreach($concerned as $item)
                <div class="col-md-6 text-right">
                    @if( $item->NameUM !='no unit')
                        {!! Form::label($item->Nomenclature_ID.'-from-'.$item->Unite_Mesure_ID, $item->NameN .' ('. $item->NameUM.') From')  !!}
                    @else
                        {!! Form::label($item->Nomenclature_ID.'-from-'.$item->Unite_Mesure_ID, $item->NameN .' From')  !!}
                    @endif
                        {!! Form::Number($item->Nomenclature_ID.'-from-'.$item->Unite_Mesure_ID,null,['class' => 'input food-input', 'step' => 'any',
                                                                              'min' => floor($item->min), 'max'=>ceil($item->max),
                                                                               'placeholder'=>floor($item->min)]) !!}

                        {!! Form::label($item->Nomenclature_ID.'-to-'.$item->Unite_Mesure_ID, 'To')  !!}
                        {!! Form::Number($item->Nomenclature_ID.'-to-'.$item->Unite_Mesure_ID,null,['class' => 'input food-input', 'step' => 'any',
                                                                           'min' => floor($item->min), 'max'=>ceil($item->max),
                                                                           'placeholder'=>ceil($item->max)]) !!}


                        {!! Form::checkbox($item->Nomenclature_ID.'-view-'.$item->Unite_Mesure_ID,$item->Nomenclature_ID, false); !!}
                    </div>
            @endforeach
            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
            {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection










