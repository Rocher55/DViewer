@extends('layouts.template')

@section('content')



        @if(isset($type) && count($type))
            @foreach($type as $t)
                {!! $t->Protocol_Type !!}
                @endforeach
            @endif
    </div>
@endsection
