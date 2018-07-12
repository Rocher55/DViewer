@extends('layouts.template')

@section('content')
    <div class="container-body">
        {!! Form::open(['url' => 'research/cid', 'method' => 'post']) !!}

            <div class="col-md-8 col-md-offset-2 text-center">
                {!! Form::label('cid-from', 'CID')  !!}
                <select data-placeholder="Choose something..." class="cid-chosen-tag"  multiple="true" name="cid[]">
                    <option value=""></option>
                    @foreach($cids as $cid)
                        <option value="{!! $cid->CID_ID !!}">{!! $cid->CID_Name !!}</option>
                        @endforeach
                </select>
            </div>



        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
