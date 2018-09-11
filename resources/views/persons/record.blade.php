@extends('layouts.app')

@section('content')

<table class="table table-striped">
    <thead>
    <th><a href="/people?sort=id&order=">ID</a></th>
    <th><a href="/people?sort=name&order=>">{{trans('company.name')}}</a></th>
    <th><a href="/people?sort=adress&order=">{{trans('company.adress')}}</a></th>
    <th><a href="/people?sort=phone&order=">{{trans('company.phone')}}</a></th>
    <th><a href="/people?sort=email&order=">{{trans('company.email')}}</a></th>
</thead>

<tbody>
    @foreach ($view as $record)

        <tr style="background-color: lightgrey">
            <td>{{ $record->id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->adress }}</td>
            <td>{{ $record->phone }}</td>
            <td>{{ $record->email }}</td>
        </tr>
        
    @endforeach
    
</tbody>
</table>
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection