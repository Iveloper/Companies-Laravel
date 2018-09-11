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
{!! Form::open(array('route'=> 'person_store')) !!}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        <label for="name">{{trans('company.name')}}</label><br>
        {!! Form::text('name', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="adress">{{trans('company.adress')}}</label><br>
        {!! Form::text('adress', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="phone">{{trans('company.phone')}}</label><br>
        {!! Form::text('phone', '', array('class'=>"form-control")) !!}
    </div>
    
    <div class="form-group row">
        <label for="email">{{trans('company.email')}}</label><br>
        {!! Form::text('email', '', array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection