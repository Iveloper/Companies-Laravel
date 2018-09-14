@extends('layouts.app')

@section('content')

<table class="table table-striped">
    <thead>
    <th>ID</th>
    <th>{{trans('company.name')}}</th>
    <th>{{trans('company.adress')}}</th>
    <th>{{trans('company.phone')}}</th>
    <th>{{trans('company.email')}}</th>
    <th>{{trans('company.company')}}</th>
</thead>

<tbody>
    @foreach ($view as $record)

        <tr style="background-color: lightgrey">
            <td>{{ $record->id }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->adress }}</td>
            <td>{{ $record->phone }}</td>
            <td>{{ $record->email }}</td>
            <td>{{ $record->company }}</td>
        </tr>
        
    @endforeach
    
</tbody>
</table>
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection