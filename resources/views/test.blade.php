@extends('layouts.template')

@section('content')
{{var_dump(Session::get("analyseID"))}}
<div class="container table-responsive">
    <table class="table table-bordered" style="width: 100px;">
        <thead>
            <tr>
                <th width="70%">SUBJID</th>
                <th>Sex</th>
                <th>Center</th>
                <th>Protocol</th>
                <th>Class</th>
                @foreach($bioCid as $item)
                    <th>{{$item}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

                @foreach($keys as $key)
                    <tr>
                    <td>{{$key}}</td>
                    <td>{{$array[$key]['Sex']}}</td>
                    <td>{{$array[$key]['Center']}}</td>
                    <td>{{$array[$key]['Protocol']}}</td>
                    <td>{{$array[$key]['Class']}}</td>

                    @foreach($bioCid as $item)
                        <td>@if(isset($array[$key][$item]))
                                {{$array[$key][$item]}}
                            @else
                                N/A
                            @endif

                        </td>
                    @endforeach
                    </tr>
                @endforeach


        </tbody>
    </table>

</div>
<div class="container">
    {{$array->links()}}
</div>




    
    {{--
    {!! var_dump(Session::get('geneID')) !!}
    {!! var_dump(Session::get('cidID')) !!}

    {!! var_dump(Session::get('biochemistryToView')) !!}
    --}}






@endsection
