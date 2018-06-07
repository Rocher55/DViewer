@extends('layouts.template')


@section('content')

    <div class="container">
        <ul class="nav nav-tabs">
            @foreach($family as $item => $value)
                @if(key($family) == $item)
                    <li class="active"><a data-toggle="tab" href={!! "#".$item !!}>{!! $value !!}</a></li>

                    @else
                    <li><a data-toggle="tab"  href={!! "#".$item !!}>{!! $value !!}</a></li>
                @endif
            @endforeach
        </ul>

        {!! Form::open(['url' => 'research/biochemistry', 'method' => 'post']) !!}

            <div class="tab-content biochemistry">
                @foreach($family as $item => $value)

                @if(key($family) == $item)
                    <div id={!!'"'.$item.'"' !!} class="tab-pane fade in active">

                @else
                    <div id={!!'"'.$item.'"' !!} class="tab-pane fade">
                @endif

                    @foreach($concerned as $itemC)
                        @if($itemC->Family_ID == $item)
                        <div class="col-md-6 text-right">

                            @if($itemC->NameUM === 'Pas d unite')
                                {!! Form::label($itemC->Nomenclature_ID.'-from-'.$itemC->Unite_Mesure_ID, $itemC->NameN .' From')  !!}
                            @else
                                {!! Form::label($itemC->Nomenclature_ID.'-from-'.$itemC->Unite_Mesure_ID, $itemC->NameN .' ('. $itemC->NameUM.') From')  !!}
                            @endif
                            {!! Form::Number($itemC->Nomenclature_ID.'-from-'.$itemC->Unite_Mesure_ID,null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                            {!! Form::label($itemC->Nomenclature_ID.'-to-'.$itemC->Unite_Mesure_ID, 'To')  !!}
                            {!! Form::Number($itemC->Nomenclature_ID.'-to-'.$itemC->Unite_Mesure_ID,null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}
                            {!! Form::checkbox($itemC->Nomenclature_ID.'-view-'.$itemC->Unite_Mesure_ID,$itemC->Nomenclature_ID, false); !!}
                        </div>
                        @endif
                    @endforeach
                    </div>
                @endforeach
            </div>

            <div class="container ">
                {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "window.history.back();"]) !!}
                {!! Form::submit('Next', ['class' => 'next-button']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection










