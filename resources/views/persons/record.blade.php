@extends('layout.main')

@section('content')

<table class="table table-striped">
    <thead>
    <th><a href="/people?sort=id&order=">ID</a></th>
    <th><a href="/people?sort=name&order=>">Name</a></th>
    <th><a href="/people?sort=adress&order=">Adress</a></th>
    <th><a href="/people?sort=phone&order=">Phone</a></th>
    <th><a href="/people?sort=email&order=">Email</a></th>
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
            <td>{{ $record->phone }}</td>
            <td>{{ $record->email }}</td>
        </tr>
        
    @endforeach
    
</tbody>
</table>

@endsection