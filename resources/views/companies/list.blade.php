@extends('layouts.app')
@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
@can('create', $model)
<a href="{{ route('company_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.add')}}</button></a>
@endcan

<form method='GET' class="form-horizontal" action='/company' style="margin-top: 10px; margin-bottom: 10px;">
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
        <td>{{ $company->id }}</td>
        <td><a href="{{ route('company_show', $company->id) }}">{{ $company->name }}</a></td>
        <td>{{ $company->adress }}</td>
        <td>{{ $company->bulstat }}</td>
        <td>{{ $company->contragent_type }}</td>
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
    @endsection