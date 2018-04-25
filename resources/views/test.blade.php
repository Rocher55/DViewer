@extends('layouts.template')

@section('content')

    <div class="container container-body">
        @if(count($data)&& isset($data))
            @foreach($data as $d)
                   {!! $d  !!}
            @endforeach
        @else
            rien
        @endif

        from session
        @if(Session::has('bioToView'))
            @foreach(Session::get('bioToView') as $t)
                {!! $t !!}
                @endforeach
            @endif
    </div>
@endsection
