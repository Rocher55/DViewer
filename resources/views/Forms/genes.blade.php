@extends('layouts.template')




@section('content')
    <div class="container-body ">
        {!! Form::open(['url' => 'research/analyse', 'method' => 'post']) !!}



        <div class="col-md-4 offset-md-2">
            {!! Form::label('sampleType', 'Sample')  !!}
            <select data-placeholder="Choose a sample ..." class="chosen-tag" multiple="true" name="sampleType[]">
                @foreach($result as $item)
                    <option value="{!! $item->Gene_Symbol !!}">{!! $item->Probe_ID!!}</option>
                @endforeach
            </select>
        </div>


        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "window.history.back();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
