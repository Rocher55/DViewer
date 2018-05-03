@extends('layouts.template')

@section('content')

    <div class="container-body">
        {!! Form::open(['url' => 'research/cid', 'method' => 'post']) !!}

            <div class="col-md-5 col-md-offset-2">
                {!! Form::label('cid-from', 'From')  !!}
                <select data-placeholder="Choose something..." class="single-chosen-tag"  name="cid-from">
                    <option value=""></option>
                    @foreach($cids as $cid)
                        <option value="{!! $cid->CID_ID !!}">{!! $cid->CID_Name !!}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                {!! Form::label('cid-to', 'To')  !!}
                <select data-placeholder="Choose something..." class="single-chosen-tag"  name="cid-to">
                    <option value=""></option>
                    @foreach($cids as $cid)
                        <option value="{!! $cid->CID_ID !!}">{!! $cid->CID_Name !!}</option>
                    @endforeach
                </select>
            </div>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>




@endsection
