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
<a href="{{ route('user_upload', Auth::user()->id) }}"><img src="{{ url('/') }}/uploads/avatars/{{ Auth::user()->username }}/{{ Auth::user()->avatar }}" style="width: 120px;
                                                            max-height: 110px;
                                                            display: block;
                                                            margin-left: auto;
                                                            margin-right: auto;
                                                            "></a>
{!! Form::open(array('route' => array('user_file', $upload[0]->id), 'files'=>true)) !!}
<label for="change_avatar" class='control-label' style ='display: flex; justify-content: center'>{{trans('company.change_avatar')}}</label><br>
{!! Form::file('avatar', ['style' => 'margin: 15px auto']) !!}
{!! Form::submit('Save', ['class' => 'btn btn-success', 'style' => 'width:100%']) !!}

{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%; margin-top: 15px;">{{trans('company.goBack')}}</button></a>
@endsection