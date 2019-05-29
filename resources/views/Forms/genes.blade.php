@extends('layouts.template')

@section('content')
    <div class="help-tip">
        <p>
            <b>To see gene expression appear in result set there are 2 possibilities :</b>
            <br>
            <br>
                - type at least the first 2 characters of the “Gene symbol” in the search bar
                then hit enter. Select the gene and do a right-click on this one.
            <br>
                - or the second one, type the “Gene symbol” directly in the text area and separate them with a semicolon.

        </p>
    </div>

    <div class="container-body ">
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="row">
                    <div class="search">
                        {!! Form::text('recherche','',[ 'id'=>'recherche', 'placeholder'=>'Search a gene symbol ...']) !!}
                    </div>
                </div>

                <div class="row">
                    {!! Form::label('gene', 'Gene')  !!}
                    <ul class="list-group" name="gene">
                    </ul>
                    <!--<select placeholder="Select a gene ..." class="select-gene" name="gene">
                    </select> -->
                </div>
            </div>

            {!! Form::open(['url' => 'research/select-gene', 'method' => 'post', 'id'=>'form']) !!}
            {{ Form::hidden('genes', '',['cols'=>'50', 'rows'=>'10', 'id'=>'genes']) }}
            <div class="col-md-8 text-center">
                <!--{!! Form::textarea('genes', '',['cols'=>'50', 'rows'=>'10', 'id'=>'genes', 'placeholder'=>'Enter the gene symbol separated by semicolon']) !!}-->
                <ul class="list-group" name="SelectedGenes">
                </ul>
            </div>
        </div>

        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "sendPrevious();"]) !!}
        {!! Form::button('Clear', ['class' => 'reset-button', 'onclick' => "resetFields();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection


@section('script')
    <script src="{!! asset('js/ajax-gene.js') !!}"></script>
@endsection

