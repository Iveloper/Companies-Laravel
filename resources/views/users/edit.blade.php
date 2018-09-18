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
        <label for="name">{{trans('company.name')}}</label><br>
        {!! Form::text('username', $edit[0]->username, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="email">{{trans('company.email')}}</label><br>
        {!! Form::text('email', $edit[0]->email, array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="active">{{trans('company.active')}}</label><br>
        <select name="active">
            @if($edit[0]->active == 1)
            <option selected = 'selected 'value="1">{{trans('company.active')}}</option>
            <option value='0'>{{trans('company.deactive')}}</option>

            @else
            <option selected="selected" value="0">{{trans('company.deactive')}}</option>
            <option value='1'>{{trans('company.active')}}</option>
            @endif
        </select><br><br>
    </div>
    
    <div class="form-group row">     
        <label for="preferred_language">{{trans('company.preferred_language')}}</label><br>
        @foreach ($lang as $language => $val)
        @if ($edit[0]->language_id == $val->id)
        <img src="/uploads/flags/{{ $val->flag }}" style="width: 40px; height: 40px;">
        @endif
        @endforeach

        <select name="language_id">
            @foreach ($lang as $language => $val)
            @if ($edit[0]->language_id == $val->id)
            <option selected='selected' value="{{$val->id}}">{{$val->language}}</option>

            @else
            <option value="{{$val->id}}">{{$val->language}}</option>
            @endif
            <img src="/uploads/flags/{{ $val->flag }}" style="width: 45px; max-height: 40px; border-radius: 89%;">
            @endforeach
        </select>
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection

