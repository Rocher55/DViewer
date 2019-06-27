@extends('layouts.template')

@section('content')
    <div class="help-tip">
        <p>Correctly import DATA in Excel. <br><br><img src="{{asset('/img/import.png')}}" width="650" /></p>
    </div>

    <div class="boutons">
        <a href={{ route('home') }} class="btn btn-primary">Home</a>
        <a href="{{ route('export') }}" class="btn btn-primary" >Export</a>
    </div>

    <div class="tableFixHead">
    <table >
        <thead >
            <tr class="border_bottom">
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
                    <tr class="border_bottom">
                    <th scope="row">{{$array[$key]['SUBJID']}}</th>
                    <td>{{$array[$key]['Sex']}}</td>
                    <td>{{$array[$key]['Center']}}</td>
                    <td>{{$array[$key]['Protocol']}}</td>
                    <td>{{$array[$key]['Class']}}</td>

                    @foreach($cols as $item)
                        <td>@if(isset($array[$key][$item]))
                                {{ round($array[$key][$item],2)}}
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
@endsection
