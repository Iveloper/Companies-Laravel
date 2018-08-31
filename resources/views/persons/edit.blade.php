@extends('layout.main')

@section('content')

{!! Form::open(['url'=>'/people/editForm', 'method'=>'post']) !!}
{{ Form::hidden('id', $edit[0]->id) }}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        {!! Form::label('name', 'Name') !!}<br>
        {!! Form::text('name', $edit[0]->name, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('email', 'E-Mail Address') !!}<br>
        {!! Form::text('email', $edit[0]->email, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('adress', 'Adress') !!}<br>
        {!! Form::text('adress', $edit[0]->adress, array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        {!! Form::label('phone', 'Phone') !!}<br>
        {!! Form::text('phone', $edit[0]->phone, array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

    
</div>
{!! Form::close() !!}

@endsection
