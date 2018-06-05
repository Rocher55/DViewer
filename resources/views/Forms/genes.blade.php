@extends('layouts.template')




@section('content')

    <div class="container-body ">

        <div class="row">
            <div class="col-md-4 text-center">
                <div class="row">
                    <div class="search">
                        {!! Form::text('recherche','',[ 'id'=>'recherche', 'placeholder'=>'Search a gene ...']) !!}
                    </div>
                </div>

                <div class="row">
                    {!! Form::label('gene', 'Gene')  !!}
                    <select data-placeholder="Select a gene ..." class="select-gene" name="gene">
                    </select>
                </div>
            </div>

            {!! Form::open(['url' => 'research/select-gene', 'method' => 'post']) !!}
            <div class="col-md-8 text-center">
                {!! Form::textarea('genes', '',['cols'=>'50', 'rows'=>'10', 'id'=>'genes']) !!}
            </div>
        </div>


        {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "window.history.back();"]) !!}
        {!! Form::submit('Next', ['class' => 'next-button']) !!}
        {!! Form::close() !!}
    </div>
@endsection


@section('script')
    <script src="{!! asset('js/ajax-gene.js') !!}"></script>
@endsection




{{--

<script type="text/javascript">
    $( '#recherche').autocomplete({
        source: '{!!URL::route('ajax')!!}',
        minLength: 2,
        select: function(event, ui) {
            $('#recherche').val(ui.item.value);
        }
    });
</script>
--}}
