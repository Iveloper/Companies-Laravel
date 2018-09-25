@extends('layouts.app')
@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
@can('create', $model)
<a href="{{ route('company_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.add')}}</button></a>
@endcan

<div style='display: flex;'>
    <button type='button' class='btn btn-info' id='filters' style="display: flex;"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
    <button type='button' class='btn btn-warning' id='multiple' style="display: flex; margin-left: 10px;"><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></button>
    <button type='button' class='btn btn-warning' id='editMultiple' style="display: none; margin-left: 572px;">Edit types for selected</button>
    <button type='button' class='btn btn-danger' id='deleteMultiple' style="display: none; margin-left: 10px;">Delete selected</button>
</div>
<form method='GET' class="form-horizontal" id='searchForm' action='/company' style="margin-top: 10px; margin-bottom: 10px; display:none;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[name]" placeholder="{{trans('company.searchByName')}}" value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[adress]" placeholder="{{trans('company.searchByAddress')}}" value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[bulstat]" placeholder="{{trans('company.searchByBulstat')}}" value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">{{trans('company.search')}}</button>
    </div>
</form>

<table class="table table-striped">
    <thead>
    <th><input type="checkbox" name="" class="selectall" style='display: none;'/></th>
    <th><a href="/company?sort=id&order={{ $companies['order'] }}">ID</a></th>
    <th><a href="/company?sort=name&order={{ $companies['order'] }}">{{trans('company.name')}}</a></th>
    <th><a href="/company?sort=adress&order={{ $companies['order'] }}">{{trans('company.adress')}}</a></th>
    <th><a href="/company?sort=bulstat&order={{ $companies['order'] }}">{{trans('company.bulstat')}}</a></th>
    <th><a href="/company?sort=contragent_type&order={{ $companies['order'] }}">{{trans('company.contragent_type')}}</a></th>
    <th><a href="/company?sort=note&order={{ $companies['order'] }}">{{trans('company.note')}}</a></th>
    <th></th>
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($companies['companies'] as $company)

    <tr>
        <td><input type='checkbox' name='deleteArray[]' value="{{ $company->id }}" class='checkboxForOne' style='display: none;'/></td>
        <td>{{ $company->id }}</td>
        <td id='companyName'><a href="{{ route('company_show', $company->id) }}">{{ $company->name }}</a></td>
        <td>{{ $company->adress }}</td>
        <td>{{ $company->bulstat }}</td>
        <td id='{{ $company->ct_id }}'>{{ $company->contragent_type }}</td>
        <td>{{ $company->note }}</td>
        @can('show', $model)
        <td><a href="{{ route('company_show', $company->id) }}"><button type="submit" class="btn btn-info">{{trans('company.info')}}</button></a></td>
        @endcan
        @can('edit', $model)
        <td><a href="{{ route('company_edit', $company->id) }}"><button type="submit" class="btn btn-warning">{{trans('company.edit')}}</button></a></td>
        @endcan
        @can('delete', $model)
        <td><a href="{{ route('company_delete', $company->id) }}" onclick="return confirm('Are you sure you want to delete this company?')"><button type="submit" class="btn btn-danger">{{trans('company.delete')}}</button></a></td>
        @endcan
    </tr>

    @endforeach

</tbody>
</table>
{{ $companies['companies']->links() }}

<form method="GET" action="/company"  style="text-align: center;">
    <select name="option" style="margin-right: 2px;">

        <?php $perPageOptions = [5, 10, 15, 20] ?>
        @foreach ($perPageOptions as $perPageOption) 
        @if ($perPageOption == $companies['perPage'])
        <option selected="selected" value="{{ $perPageOption }}" >{{ $perPageOption }}</option>
        @else
        <option value="{{ $perPageOption }}" >{{ $perPageOption }}</option>

        @endif

        @endforeach
        <button><input type="submit" class="btn btn-info" style="margin-left: 2px;"></button>
    </select>
    <div><h4>{{trans('company.totalRows')}} {{ $companies['companies']->total() }}</h4></div>
</form>


<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content" style="background-color: #e2e2e2;">
        <span class="close"><i class="fa fa-times" style="font-size:24px"></i></span>

        <div class="form-group row" style='text-align: center'>
            <label for="contragent_type" style='margin-left: 35px;'>{{trans('company.contragent_type')}}</label><br>
            <select id="selectCT" name="contragent_type" style='width: 300px;'>
                <option name="contragent_type" id="selectedCT"></option>
                @foreach ($getTypes as $contragentType => $val)

                <option name="contragent_type" id="selectedCT" value="{{$val->id}}">{{$val->name}}</option>

                @endforeach
            </select>
        </div>
            <button type='button' class='btn btn-warning' id='ctSubmit' style="display: flex; margin-left: 10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>

    </div>
</div>

<script>
    $(document).ready(function () {

        $('#filters').click(function () {
            $('#searchForm').toggle();
        });

        $('tr').find('td#3').each(function () {

            $(this).parent().attr('style', 'background-color: #ada6a6');

        });
        $('tr').find('td#2').each(function () {

            $(this).parent().attr('style', 'background-color: #a4b8ca');

        });

        $('tr').find('td#1').each(function () {

            $(this).parent().attr('style', 'background-color: #d69291');

        });

        $('#multiple').click(function () {
            $(".selectall").toggle();
            $('.checkboxForOne').toggle();
            $("#deleteMultiple").toggle();
            $("#editMultiple").toggle();
        });

        $('.selectall').click(function () {
            if ($(this).is(':checked')) {
                $('.checkboxForOne').attr('checked', true);
            } else {
                $('.checkboxForOne').attr('checked', false);
            }
        });

        $("#deleteMultiple").click(function () {
            var arr = [];
            var checkbox_value = "";
            $(":checkbox").each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    checkbox_value += $(this).val() + " ";
                    arr.push($(this).val());
                }
            });
            var jsonString = JSON.stringify(arr);
            var token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "/company/multiple/delete",
                data: {data: jsonString,
                    _token: token
                },
                cache: false,

                success: function () {
                    location.reload();
                }
            });
        });

        $("#editMultiple").click(function (event) {
            event.preventDefault();
            $("#myModal").attr('style', 'display: block');

            var arr = [];
            var ctType;
            var checkbox_value = "";
            $(":checkbox").each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    checkbox_value += $(this).val() + " ";
                    arr.push($(this).val());
                }
            });

            var jsonString = JSON.stringify(arr);
            var token = $('input[name="_token"]').val();

            $("#ctSubmit").click(function () {
                ctType = $("#selectedCT:checked").val();
                        $.ajax({
                            type: 'POST',
                            url: "/company/multiple/edit",
                            data: {data: jsonString,
                                contragent_type: ctType,
                                _token: token
                            },
                            cache: false,

                            success: function () {
                                location.reload();
                            }
                        });
            });

        });

        $(".close").click(function () {

            $("#myModal").attr('style', 'display: none');
        });
    });
</script>
@endsection