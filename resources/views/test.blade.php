@extends('layouts.template')

@section('content')

    <div class="container table-responsive">
    <table class="table table-bordered" style="width: 100px;">
        <thead>
            <tr>
                <th scope="col">SUBJID</th>
                <th scope="col">Sex</th>
                <th scope="col">Center</th>
                <th scope="col">Protocol</th>
                <th scope="col">Class</th>
                @foreach($cols as $item)
                    <th scope="col">{{$item}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

                @foreach($keys as $key)
                    <tr>
                    <th scope="row">{{$array[$key]['SUBJID']}}</th>
                    <td>{{$array[$key]['Sex']}}</td>
                    <td>{{$array[$key]['Center']}}</td>
                    <td>{{$array[$key]['Protocol']}}</td>
                    <td>{{$array[$key]['Class']}}</td>

                    @foreach($cols as $item)
                        <td>@if(isset($array[$key][$item]))
                                {{ $array[$key][$item]}}
                            @else

                            @endif

                        </td>
                    @endforeach
                    </tr>
                @endforeach


        </tbody>
    </table>

</div>
<div class="container">
    {{$keys->links()}}

</div>



    {{--
    {!! var_dump(Session::get('geneID')) !!}
    {!! var_dump(Session::get('cidID')) !!}

    {!! var_dump(Session::get('biochemistryToView')) !!}
    --}}






@endsection
