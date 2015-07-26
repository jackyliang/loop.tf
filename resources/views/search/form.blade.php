{!! Form::open([
    'action' => ['SchedulizerController@results'],
    'method' => 'GET',
    'class' => 'form-inline'
]) !!}
    <div class="col-lg-10">
        <div class="input-group">
            {!! Form::text('q', $term, [
                'class' => 'form-control',
                'id' =>  'q',
                'placeholder' =>  'i.e. ECE 201, Digital Logic, Kandasamy, or 41045'
            ]) !!}
        <span class="input-group-btn">
            {!! Form::submit('Search', array('class' => 'btn btn-primary')) !!}
        </span>
        </div>
    </div>
{!! Form::close() !!}

@include('js.classes-autocomplete')
