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
        <label for="email">{{trans('company.email')}}</label><br>
        {!! Form::text('email', '', array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        <label for="username">{{trans('company.username')}}</label><br>
        {!! Form::text('username', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="password">{{trans('company.password')}}</label><br>
        {!! Form::password('password', '', array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        <label for="active">{{trans('company.active')}}</label><br>
        {!! Form::select('active', array('0' => 0, '1' => 1), array('class'=>"form-control")) !!}
        
    </div>
    
    <div class="form-group row">
         <label for="preferred_language">{{trans('company.preferred_language')}}</label><br>
    <select name="language_id">
            @foreach ($lang as $language => $val)

            <option value="{{$val->id}}">{{$val->language}}</option>
            
            @endforeach
        </select>
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}

    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection

