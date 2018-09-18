@extends('layouts.app')

@section('content')

<table class="table table-striped">
    <thead>
    <th>{{trans('company.roles_id')}}</th>
    <th>{{trans('company.roles_name')}}</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
</thead>


<tbody>
    @foreach ($roles as $role)
    <tr style="background-color: lightgrey">
        <td>{{ $role->id }}</td>
        <td>{{ $role->name }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="{{ route('permissions_list', $role->id) }}"><button type="submit" class="btn btn-warning">{{trans('company.roles_edit')}}</button></a></td>
        @endforeach
</tbody>

@endsection