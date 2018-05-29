@extends('layouts.template')




@section('content')
    <div class="container-body ">
        {!! Form::open(['url' => 'research/analyse', 'method' => 'post']) !!}


        <div class="row">
            <div class="col-md-8 offset-md-4">
                {!! Form::label('gene', 'Gene')  !!}
                <select data-placeholder="Choose a sample ..." class="chosen-tag" multiple="true" name="gene[]">
                    @foreach($result as $item)
                        <option value="{!! $item->un !!}">{!! $item->deux!!}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            {!! Form::textarea('genes', '',['cols'=>'50', 'rows'=>'10']) !!}
        </div>


        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "window.history.back();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
