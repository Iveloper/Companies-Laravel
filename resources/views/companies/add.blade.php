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

{!! Form::open(array('route'=> 'company_store')) !!}
{!! Form::hidden('user_id', Auth::user()->id ) !!}
<div class='form' style='text-align: center'>
    <div class="form-group row">
        <label for="name">{{trans('company.name')}}</label><br>
        {!! Form::text('name', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="email">{{trans('company.email')}}</label><br>
        {!! Form::text('email', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="bulstat">{{trans('company.bulstat')}}</label><br>
        {!! Form::text('bulstat', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="adress">{{trans('company.adress')}}</label><br>
        {!! Form::text('adress', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="note">{{trans('company.note')}}</label><br>
        {!! Form::text('note', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="contragent_type">{{trans('company.contragent_type')}}</label><br>
        <select name="contragent_type">
            @foreach ($getTypes as $contragentType => $val)

            <option value="{{$val->id}}">{{$val->name}}</option>

            @endforeach
        </select>
    </div>

    <div class="form-group row">
        <label for="country">{{trans('company.country')}}</label><br>
        <select name="country" id="country">
            <option value="0"></option>
            @foreach ($getCountries as $getCountry)

            <option value="{{$getCountry->id}}">{{$getCountry->name}}</option>

            @endforeach
        </select>
    </div>

    <div class="form-group row">
        <label for="country">{{trans('company.city')}}</label><br>
        <select name="city" id="city">


            <option value="0"></option>


        </select>
    </div>
    
    <div class="form-group row">
        <label for="phone">{{trans('company.phone')}}</label><br>
        {!! Form::text('phone', '', array('class'=>"form-control")) !!}
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>

<script>

    $(document).ready(function () {

        $("#country").on("change", function (event) {
            event.preventDefault();

            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'GET',
                url: "/company/city",
                data: {
                    id: $(this).val(),
                    _token: token
                },
                success: function (data) {
                   $('#city option').remove();
                   
                   $(data).each(function (index, value) {
                    $("#city").append($('<option>', {
                        value: value.name,
                        text: value.name
                    }, '</option>'));
                });

                },

            });

        });

    });

</script>
@endsection