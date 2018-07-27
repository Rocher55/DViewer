@extends('layouts.template')

@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/cid', 'method' => 'post', 'id'=>'form']) !!}

            <div class="col-md-8 col-md-offset-2 text-center">
                {!! Form::label('cid-from', 'Clinical Investigation Day')  !!}
                <select data-placeholder="Choose the cid(s) ..." class="cid-chosen-tag"  multiple="true" name="cid[]">
                    <option value=""></option>
                    @foreach($cids as $cid)
                        <option value="{!! $cid->CID_ID !!}">{!! $cid->CID_Name !!}</option>
                        @endforeach
                </select>
            </div>

        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
        {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
