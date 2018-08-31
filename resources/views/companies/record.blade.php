@extends('layout.main')

@section('content')

<table class="table table-striped">
    <thead>
    <th><a href="/company?sort=id&order=">ID</a></th>
    <th><a href="/company?sort=name&order=>">Name</a></th>
    <th><a href="/company?sort=adress&order=">Adress</a></th>
    <th><a href="/company?sort=bulstat&order=">Bulstat</a></th>
    <th><a href="/company?sort=email&order=">Email</a></th>
    <th><a href="/company?sort=phone&order=">Phone</a></th>
    <th><a href="/company?sort=note&order=">Note</a></th>
    <th></th>
    <th></th>
    <th></th>
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

@endsection