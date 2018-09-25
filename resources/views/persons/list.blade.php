@extends('layouts.app')

@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@can('create', $model)
<a href="{{ route('person_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.add')}}</button></a>
@endcan
<div style='display: flex;'>
    <button type='button' class='btn btn-info' id='filters' style="display: flex;"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
    <button type='button' class='btn btn-warning' id='multiple' style="display: flex; margin-left: 10px;"><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></button>
    <button type='button' class='btn btn-danger' id='deleteMultiple' style="display: none; margin-left: 737px;">Delete selected</button>
</div>
<form method='GET' class="form-horizontal" action='/people' id='searchForm' style=" margin-top: 10px; margin-bottom: 10px; display: none;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[name]" placeholder="{{trans('company.searchByName')}}" value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[adress]" placeholder="{{trans('company.searchByAddress')}}" value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[phone]" placeholder="{{trans('company.searchByPhone')}}" value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[email]" placeholder="{{trans('company.searchByEmail')}}" value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">{{trans('company.search')}}</button>
    </div>
</form>

<table class="table table-striped">
    <thead>
    <th><input type="checkbox" name="sample" class="selectall" style='display: none;'/></th>
    <th><a href="/people?sort=id&order={{ $persons['order'] }}">ID</a></th>
    <th><a href="/people?sort=name&order={{ $persons['order'] }}">{{trans('company.name')}}</a></th>
    <th><a href="/people?sort=adress&order={{ $persons['order'] }}">{{trans('company.adress')}}</a></th>
    <th><a href="/people?sort=phone&order={{ $persons['order'] }}">{{trans('company.phone')}}</a></th>
    <th><a href="/people?sort=email&order={{ $persons['order'] }}">{{trans('company.email')}}</a></th>
    <th><a href="/people?sort=company&order={{ $persons['order'] }}">{{trans('company.company')}}</a></th>

    <th></th>
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($persons['persons'] as $company)

    <tr>
        <td><input type='checkbox' name='deleteArray[]' value="{{ $company->id }}" class='checkboxForOne' style='display: none;'/></td>
        <td>{{ $company->id }}</td>
        <td><a href="{{ route('person_show', $company->id) }}">{{ $company->name }}</a></td>
        <td>{{ $company->adress }}</td>
        <td>{{ $company->phone }}</td>
        <td>{{ $company->email }}</td>
        <td>{{ $company->company }}</td>
        @can('show', $model)
        <td><a href="{{ route('person_show', $company->id) }}"><button type="submit" class="btn btn-info">{{trans('company.info')}}</button></a></td>
        @endcan
        @can('edit', $model)
        <td><a href="{{ route('person_edit', $company->id) }}"><button type="submit" class="btn btn-warning">{{trans('company.edit')}}</button></a></td>
        @endcan
        @can('delete', $model)
        <td><a href="{{ route('person_delete', $company->id) }}" onclick="return confirm('Are you sure you want to delete this person?')"><button type="submit" class="btn btn-danger">{{trans('company.delete')}}</button></a></td>
        @endcan
    </tr>

    @endforeach

</tbody>
</table>
{{ $persons['persons']->links() }}

<form method="GET" action="/people" style="text-align: center;">
    <select name="option" style="margin-right: 2px;">

        <?php $perPageOptions = [5, 10, 15, 20] ?>
        @foreach ($perPageOptions as $perPageOption) 
        @if ($perPageOption == $persons['perPage'])
        <option selected="selected" value="{{ $perPageOption }}" >{{ $perPageOption }}</option>
        @else
        <option value="{{ $perPageOption }}" >{{ $perPageOption }}</option>

        @endif

        @endforeach
        <input type="submit" class="btn btn-info" style="margin-left: 2px;"></button>
    </select>
    <div><h4>{{trans('company.totalRows')}} {{ count($persons['total']) }}</h4></div>

    <script>
        $(document).ready(function () {

            $('#filters').click(function () {
                $('#searchForm').toggle();
            });

            $('#multiple').click(function () {
                $(".selectall").toggle();
                $('.checkboxForOne').toggle();
                $("#deleteMultiple").toggle();
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
                   url: "/people/multiple/delete",
                   data: {data : jsonString,
                       _token: token
        },
                   cache: false,
                   
                   success: function(){
                       location.reload();
                   }
                });
            });
            
        });
    </script>
    @endsection

