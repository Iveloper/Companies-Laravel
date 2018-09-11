@extends('layouts.app')

@section('content')

<table class="table table-striped">
    <thead>
    <th><a href="/company?sort=id&order=">ID</a></th>
    <th><a href="/company?sort=name&order=>">{{trans('company.name')}}</a></th>
    <th><a href="/company?sort=adress&order=">{{trans('company.adress')}}</a></th>
    <th><a href="/company?sort=bulstat&order=">{{trans('company.bulstat')}}</a></th>
    <th><a href="/company?sort=email&order=">{{trans('company.email')}}</a></th>
    <th><a href="/company?sort=phone&order=">{{trans('company.phone')}}</a></th>
    <th><a href="/company?sort=note&order=">{{trans('company.note')}}</a></th>
</thead>

<tbody>
    @foreach ($view as $record)

        <tr style="background-color: lightgrey">
            <td>{{ $record->id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->adress }}</td>
            <td>{{ $record->bulstat }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->phone }}</td>
            <td>{{ $record->note }}</td>
        </tr>
        
    @endforeach
</tbody>
</table>
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>

@endsection