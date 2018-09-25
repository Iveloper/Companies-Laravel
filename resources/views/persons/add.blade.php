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
{{ Form::hidden('user_id', Auth::user()->id) }}

<div class='form' style='text-align: center'>
    <div class="form-group row">
        <label for="name">{{trans('company.name')}}</label><br>
        {!! Form::text('p_name', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="adress">{{trans('company.adress')}}</label><br>
        {!! Form::text('p_adress', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="phone">{{trans('company.phone')}}</label><br>
        {!! Form::text('p_phone', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="email">{{trans('company.email')}}</label><br>
        {!! Form::text('p_email', '', array('class'=>"form-control")) !!}
    </div>

    <div class="form-group row">
        <label for="birthday">{{trans('company.birthday')}}</label><br>
        <input type="text" name="date" id="date" autocomplete="off">
    </div>
    <div class="form-group row">
        <label for="company">{{trans('company.company')}}</label><br>
        <input id='companies' name='company'>
        <button type="button" class="glyphicon glyphicon-plus" id="addCompany" style="margin-right: -33px"></button>
        {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
    </div>

</div>
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>

<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content" style="background-color: #e2e2e2;">
        <span class="close"><i class="fa fa-times" style="font-size:24px"></i></span>
{!! Form::open(array('route'=> 'company_store', 'id'=>"companyForm")) !!}
{!! Form::hidden('user_id', Auth::user()->id ) !!}

        <div class='form' style='text-align: center'>
            <div class="form-group row">
                <label for="name" style="margin-right: -24px;">{{trans('company.name')}}</label><br>
                {!! Form::text('name', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
            </div>

            <div class="form-group row">
                <label for="email">{{trans('company.email')}}</label><br>
                {!! Form::text('email', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
            </div>

            <div class="form-group row">
                <label for="bulstat">{{trans('company.bulstat')}}</label><br>
                {!! Form::text('bulstat', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
            </div>

            <div class="form-group row">
                <label for="adress">{{trans('company.adress')}}</label><br>
                {!! Form::text('adress', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
            </div>

            <div class="form-group row">
                <label for="note">{{trans('company.note')}}</label><br>
                {!! Form::text('note', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
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
                {!! Form::text('phone', '', array('class'=>"form-control", 'style' => "border-color: black")) !!}
                {!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;', 'id' => 'companySubmit')) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var availableCompanies = jQuery.parseJSON('<?php echo $companies ?>');
        var autoComplete = [];
        $.each(availableCompanies, function (key, company) {
            autoComplete.push(company.name);
        });

        $("#companies").autocomplete({
            source: autoComplete
        });

        $("#date").datepicker({dateFormat: 'yy-mm-dd'});




        $("#addCompany").click(function (event) {
            event.preventDefault();

            $("#myModal").attr('style', 'display: block');

        });
         
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
        
        $("#companySubmit").click(function(event){
           window.location.reload();
        });
 
        $(".close").click(function (event) {

            $("#myModal").attr('style', 'display: none');
        });

    });
</script>
<script type="text/javascript" src="/javascript/datepicker-<?php echo $locale[0]->abbr; ?>.js"></script>
@endsection