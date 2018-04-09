@extends('layouts.template')

@section('content')

    <div class="container">
        {!! Form::open(['url' => 'research/select', 'method' => 'post']) !!}

        <div class="row">

            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                        <tr>
                            <th class="table-primary" colspan="2" scope="col">Patient</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! Form::label('p.id', 'Patient ID', ['class' => 'example'])  !!}</td>
                            <td>{!! Form::checkbox('p.id')!!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('p.sex', 'Sex', ['class' => 'example'])  !!}</td>
                            <td>{!! Form::checkbox('p.sex')!!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('p.age', 'Age', ['class' => 'example'])  !!}</td>
                            <td>{!! Form::checkbox('p.age')!!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Center</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('c.acronym', 'Acronym', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('c.acronym')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('c.city', 'City', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('c.city')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('c.country', 'Country', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('c.country')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Protocol</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('p.name', 'Name', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('p.name')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('p.type', 'Type', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('p.type')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Food diaries</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('f.valeur', 'Valeur', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('f.valeur')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('f.nomenclature', 'Nomenclature', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('f.nomenclature')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('f.unite', 'Unite', ['class' => 'example'])  !!}</td>
                        <td>{!! Form::checkbox('f.unite')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>






        </div>
            {!! Form::submit('Next') !!}
        {!! Form::close() !!}
    </div>






@endsection
