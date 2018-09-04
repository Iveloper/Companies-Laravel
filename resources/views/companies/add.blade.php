@extends('layout.main')
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
{!! Form::open(array('route'=> 'company_store')) !!}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        {!! Form::label('name', 'Name') !!}<br>
        {!! Form::text('name', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('email', 'E-Mail Address') !!}<br>
        {!! Form::text('email', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('bulstat', 'Bulstat') !!}<br>
        {!! Form::text('bulstat', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('adress', 'Adress') !!}<br>
        {!! Form::text('adress', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('note', 'Note') !!}<br>
        {!! Form::text('note', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('contragent_type', 'Type of contragent') !!}<br>
        <select name="contragent_type">
            @foreach ($getTypes as $contragentType => $val)

            <option value="{{$val->id}}">{{$val->name}}</option>
            
            @endforeach
        </select>
    </div>

    <div class="form-group row">
        {!! Form::label('phone', 'Phone') !!}<br>
        {!! Form::text('phone', '', array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

</div>
{!! Form::close() !!}
@endsection