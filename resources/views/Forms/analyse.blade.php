@extends('layouts.template')




@section('content')
    <div class="container-body ">
        {!! Form::open(['url' => 'research/analyse', 'method' => 'post', 'id'=>'form']) !!}
        <div class="col-md-4 offset-md-2">
            {!! Form::label('sampleType', 'Sample')  !!}
            {{--<select data-placeholder="Choose a sample ..." class="chosen-tag" multiple="true" name="sampleType[]" require>--}}
            <select data-placeholder="Choose a sample ..." class="analyse-chosen-tag" multiple="true" name="sampleType[]"  >
                @foreach($sample as $item)
                    <option value="{!! $item->SampleType_ID !!}">{!! $item->SampleType_Name !!}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 offset-md-2">
            {!! Form::label('technique', 'Technique')  !!}
            <select data-placeholder="Choose a technique ..." class="analyse-chosen-tag" multiple="true" name="technique[]"  >
                @foreach($technique as $item)
                    <option value="{!! $item->Technique_ID !!}">{!! $item->Technical_Name !!}</option>
                @endforeach
            </select>
        </div>



        <div class="col-md-4 offset-md-2">
            {!! Form::label('molecule', 'Molecule')  !!}
            <select data-placeholder="Choose a molecule ..." class="analyse-chosen-tag" multiple="true" name="molecule[]"  >
                @foreach($molecule as $item)
                    <option value="{!! $item->Molecule_ID !!}">{!! $item->Molecule_Name !!}</option>
                @endforeach
            </select>
        </div>

        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
        {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
