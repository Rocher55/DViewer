@extends('layouts.template')

@section('content')

    <div class="container container-body">
        {!! Form::open(['url' => 'research/select', 'method' => 'post']) !!}

        <div class="row">
            <div class="col-md-3">
                <!--Patient-->
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                        <tr>
                            <th class="table-primary" colspan="2" scope="col">Patient</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! Form::label('p.id', 'Patient ID')  !!}</td>
                            <td>{!! Form::checkbox('p.id')!!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('p.sex', 'Sex')  !!}</td>
                            <td>{!! Form::checkbox('p.sex')!!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('p.age', 'Age')  !!}</td>
                            <td>{!! Form::checkbox('p.age')!!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--Center-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Center</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('c.acronym', 'Acronym')  !!}</td>
                        <td>{!! Form::checkbox('c.acronym')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('c.city', 'City')  !!}</td>
                        <td>{!! Form::checkbox('c.city')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('c.country', 'Country')  !!}</td>
                        <td>{!! Form::checkbox('c.country')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!--Protocol-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Protocol</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('p.name', 'Name')  !!}</td>
                        <td>{!! Form::checkbox('p.name')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('p.type', 'Type')  !!}</td>
                        <td>{!! Form::checkbox('p.type')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!--Food diaries-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Food diaries</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('f.value', 'Value')  !!}</td>
                        <td>{!! Form::checkbox('f.value')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('f.nomenclature', 'Nomenclature')  !!}</td>
                        <td>{!! Form::checkbox('f.nomenclature')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('f.unite', 'Unite')  !!}</td>
                        <td>{!! Form::checkbox('f.unite')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!--Biochemistry-->
        <div class="row">
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Biochemistry</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('b.value', 'Value')  !!}</td>
                        <td>{!! Form::checkbox('b.value')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('b.nom', 'Nom')  !!}</td>
                        <td>{!! Form::checkbox('b.nom')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('b.unite', 'Unite')  !!}</td>
                        <td>{!! Form::checkbox('b.unite')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!--Analyse-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Analyse</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('a.molecule', 'Molecule')  !!}</td>
                        <td>{!! Form::checkbox('a.molecule')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('a.sample', 'Sample')  !!}</td>
                        <td>{!! Form::checkbox('a.Sample')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('a.technique', 'Technique')  !!}</td>
                        <td>{!! Form::checkbox('a.technique')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!--Gene-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">Gene</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('g.gene_symbol', 'Gene symbol')  !!}</td>
                        <td>{!! Form::checkbox('g.gene_symbol')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('g.probe_id', 'Probe ID')  !!}</td>
                        <td>{!! Form::checkbox('g.probe_id')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('g.target_id', 'Target ID')  !!}</td>
                        <td>{!! Form::checkbox('g.target_id')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('g.name', 'Name')  !!}</td>
                        <td>{!! Form::checkbox('g.Name')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!--CID-->
            <div class="col-md-3">
                <table class="table table-hover table-responsive thead-dark">
                    <thead >
                    <tr>
                        <th class="table-primary" colspan="2" scope="col">CID</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{!! Form::label('cid.number', 'Number')  !!}</td>
                        <td>{!! Form::checkbox('cid.number')!!}</td>
                    </tr>
                    <tr>
                        <td>{!! Form::label('cid.name', 'Name')  !!}</td>
                        <td>{!! Form::checkbox('cid.name')!!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
            {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection
