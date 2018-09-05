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
{!! Form::open(array('route'=> 'user_store')) !!}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        {!! Form::label('email', 'E-mail') !!}<br>
        {!! Form::text('email', '', array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        {!! Form::label('username', 'Username') !!}<br>
        {!! Form::text('username', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('password', 'Password') !!}<br>
        {!! Form::password('password', '', array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        {!! Form::label('active', 'Active') !!}<br>
        {!! Form::select('active', array('0' => 0, '1' => 1), array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}

    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">Go Back</button></a>
@endsection

