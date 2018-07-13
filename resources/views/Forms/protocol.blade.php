@extends('layouts.template')

@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/protocol', 'method' => 'post', 'id'=>'form']) !!}
            <select data-placeholder="Choose something..." class="chosen-tag" multiple="true" name="protocol[]">
                <option value=""></option>

                //Creation du groupe Longitudinal
                <optgroup label="Longitudinal">
                    @foreach($protocols as $protocol)
                        @if($protocol->Protocol_Type === "Longitudinal")
                            <option value="{!! $protocol->Protocol_ID !!}">{!! $protocol->Protocol_Name !!}</option>
                        @endif
                    @endforeach
                </optgroup>

                //Creation du groupe Transversal
                <optgroup label="Transversal">
                    @foreach($protocols as $protocol)
                        @if($protocol->Protocol_Type === "Transversal")
                            <option value="{!! $protocol->Protocol_ID !!}">{!! $protocol->Protocol_Name !!}</option>
                        @endif
                    @endforeach
                </optgroup>
            </select>
            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
            {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection


