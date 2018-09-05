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
{!! Form::open(array('route' => array('user_update', $edit[0]->id), 'method'=>'post')) !!}
{{ Form::hidden('id', $edit[0]->id) }}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        {!! Form::label('username', 'Username') !!}<br>
        {!! Form::text('username', $edit[0]->username, array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        {!! Form::label('email', 'E-mail') !!}<br>
        {!! Form::text('email', $edit[0]->email, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        {!! Form::label('active', 'Active') !!}<br>
    <select name="active">
        @if($edit[0]->active == 1)
            <option selected = 'selected 'value="1">1</option>
            <option value='0'>0</option>

       @else
            <option selected="selected" value="0">0</option>
            <option value='1'>1</option>
        @endif
    </select><br><br>
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>
    
</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">Go Back</button></a>
@endsection

