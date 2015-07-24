@extends('app')

@section('title')
    loop.tf - Schedulizer
@stop

@section('content')

    <div class="form-group">
        {!! Form::open(['action' => ['SchedulizerController@create'], 'method' => 'GET']) !!}
        {!! Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Enter name']) !!}
        {!! Form::submit('Search', array('class' => 'button expand')) !!}
        {!! Form::close() !!}
    </div>

    <script type="text/javascript">
    $(function()
    {
        $( "#q" ).autocomplete({
            source: '{{ URL('autocomplete') }}',
            minLength: 3,
            select: function(event, ui) {
                $('#q').val(ui.item.value);
            }
        });
    });
    </script>

@stop

