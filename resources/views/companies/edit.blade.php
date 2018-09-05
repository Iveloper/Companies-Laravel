@extends('layouts.app')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{!! Form::open(array('route' => array('company_update', $edit[0]->id), 'method'=>'post')) !!}
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
        {!! Form::label('bulstat', 'Bulstat') !!}<br>
        {!! Form::text('bulstat', $edit[0]->bulstat, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('adress', 'Adress') !!}<br>
        {!! Form::text('adress', $edit[0]->adress, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('contragent_type', 'Type of contragent') !!}<br>
        <select name="contragent_type">
            @foreach ($getTypes as $contragentType => $val)
            @if ($edit[0]->contragent_type == $val->id)
            <option selected='selected' value="{{$val->id}}">{{$val->name}}</option>
            @else
            <option value="{{$val->id}}">{{$val->name}}</option>
            @endif
            @endforeach
        </select>
    </div>

    <div class="form-group row">
        {!! Form::label('phone', 'Phone') !!}<br>
        {!! Form::text('phone', $edit[0]->phone, array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>


</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">Go Back</button></a>
@endsection
