@extends('layout.main')
@section('content')


{!! Form::open(array('route' => array('user_file', $upload[0]->id), 'files'=>true)) !!}
{!! Form::label('avatar', 'Choose Avatar',['class' => 'control-label']) !!}
{!! Form::file('avatar') !!}
{!! Form::submit('Save', ['class' => 'btn btn-success']) !!}

{!! Form::close() !!}
@endsection