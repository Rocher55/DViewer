@extends('layouts.template')


@section("2-options")
    <option value="34">g/day</option>
    <option value="35">g/kg/day</option>
@endsection
@section("3-options")
    <option value="34">g/day</option>
    <option value="35">g/kg/day</option>
    <option value="36">%kcal/day</option>
@endsection



@section('content')
    <div class="container-big-body">
        {!! Form::open(['url' => 'research/food', 'method' => 'post']) !!}

            <div class="row group">
                <div class="col-md-6 text-right">
                    {!! Form::label('161-from', 'Energy Intake (kJ/day)   From')  !!}
                    {!! Form::Number('161-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('161-to', 'To')  !!}
                    {!! Form::Number('161-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('165-from', 'Alcohol   From')  !!}
                    {!! Form::Number('165-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('165-to', 'To')  !!}
                    {!! Form::Number('165-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="165-unite">
                        @yield("3-options")
                    </select>
                </div>
            </div>


            <div class="row group">
                <div class="col-md-6 offset-md-2 text-right">
                    {!! Form::label('171-from', 'Carbohydrates   From')  !!}
                    {!! Form::Number('171-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('171-to', 'To')  !!}
                    {!! Form::Number('171-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="171-unite">
                        @yield("3-options")
                    </select>
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('167-from', 'Fibre   From')  !!}
                    {!! Form::Number('167-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('167-to', 'To')  !!}
                    {!! Form::Number('167-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="167-unite">
                        @yield("2-options")
                    </select>
                </div>
            </div>


            <div class="row group">
                <div class="col-md-6 offset-md-2 text-right">
                    {!! Form::label('170-from', 'Poly unsat. fatty acids   From')  !!}
                    {!! Form::Number('170-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('170-to', 'To')  !!}
                    {!! Form::Number('170-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="170-unite">
                        @yield("2-options")
                    </select>
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('164-from', 'Lipids   From')  !!}
                    {!! Form::Number('164-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('164-to', 'To')  !!}
                    {!! Form::Number('164-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="164-unite">
                        @yield("3-options")
                    </select>
                </div>
            </div>


            <div class="row group">
                <div class="col-md-6 offset-md-2 text-right">
                    {!! Form::label('169-from', 'Mono unsat. fatty acids   From')  !!}
                    {!! Form::Number('169-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}
                    {!! Form::label('169-to', 'To')  !!}
                    {!! Form::Number('169-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="169-unite">
                        @yield("2-options")
                    </select>
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('166-from', 'Sugar   From')  !!}
                    {!! Form::Number('166-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('166-to', 'To')  !!}
                    {!! Form::Number('166-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="166-unite">
                        @yield("2-options")
                    </select>
                </div>
            </div>


            <div class="row group">
                <div class="col-md-6 offset-md-2 text-right">
                    {!! Form::label('163-from', 'Proteins Food Diaries   From')  !!}
                    {!! Form::Number('163-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('163-to', 'To')  !!}
                    {!! Form::Number('163-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="163-unite">
                        @yield("3-options")
                    </select>
                </div>
                <div class="col-md-6 text-right">
                    {!! Form::label('168-from', 'Starch   From')  !!}
                    {!! Form::Number('168-from',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    {!! Form::label('168-to', 'To')  !!}
                    {!! Form::Number('168-to',null,['class' => 'input', 'step' => 'any', 'min' => '0']) !!}

                    <select data-placeholder="Choose a unite" class="unite-chosen-tag" multiple name="168-unite">
                        @yield("2-options")
                    </select>
                </div>
            </div>

            {!! Form::button('Previous', ['class' => 'previous-button', 'onclick' => "location.href='".$_SERVER['HTTP_REFERER']."';"]) !!}
            {!! Form::submit('Next', ['class' => 'next-button']) !!}

        {!! Form::close() !!}
    </div>
@endsection










