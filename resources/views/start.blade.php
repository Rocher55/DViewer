@extends('layouts.template')

@section('content')
    {{Auth::check()}}
    <div class="home">
        <div class="col-md-6">
            <div class="container table-responsive">
                <table class="table table-bordered" style="width: 100px;">
                    <thead>
                        <tr>
                            <th scope="col">Protocols</th>
                            <th scope="col">Number of patients</th>
                            <th scope="col">Classes</th>
                            <th scope="col">Minimum age</th>
                            <th scope="col">Maximum age</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($protocols as $protocol)
                            <tr>
                                <td><a href="{{ route('protocol.spec', ['id' => $protocol->Protocol_ID]) }}">
                                        <div style="height:100%;width:100%">
                                            {{$protocol->Protocol_Name}}
                                        </div>
                                    </a></td>
                                <td>{{$protocol->nb}}</td>
                                <td>{{$protocol->class}}</td>
                                <td>{{$protocol->min}}</td>
                                <td>{{$protocol->max}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <img src="{{ asset('/img/clinical.png') }}" width="100%">
            </div>
            <div class="row">
                <img src="{{ asset('/img/molecular.png') }}" width="100%">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="buttons-group" >
            <a type="button" class="button btn button-success  "  href="{{ URL::to('/research/protocol')}}">Begin a study</a>
        </div>
    </div>



@endsection
