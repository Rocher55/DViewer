@extends('layouts.template')

@section('content')
    <div class="container-body select">
        {!! Form::open(['url' => 'research/patient', 'method' => 'post']) !!}

                <div class="col-md-3 offset-md-1">
                    {!! Form::label('age-from', 'Age   From')  !!}
                    {!! Form::Number('age-from',null,['class' => 'input-age']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('age-to', 'To')  !!}
                    {!! Form::Number('age-to',null,['class' => 'input-age']) !!}
                </div>

                <div class="col-md-5 offset-md-2">
                    {!! Form::label('sex', 'Sex')  !!}
                    <select data-placeholder="Choose a sex ..." class="single-chosen-tag" multiple="false" name="sex">

                      @foreach($uniqueSex as $one)
                        <option value="{!! $one !!}">
                            @switch($one)
                                @case(1)
                                    Male
                                    @break

                                @case(2)
                                    Female
                                @break
                            @endswitch

                        </option>
                        @endforeach


                    </select>
                </div>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection