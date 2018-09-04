@extends('layouts.app')

@section('content')
<a href="{{ route('person_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">Add</button></a>


<form method='GET' class="form-horizontal" action='/people' style=" margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[name]" placeholder="Search by Name.." value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[adress]" placeholder="Search by Adress.." value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[phone]" placeholder="Search by Phone.." value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchPerson[email]" placeholder="Search by Email.." value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">Search</button>
    </div>
</form>

<table class="table table-striped">
    <thead>
    <th><a href="/people?sort=id&order={{ $persons['order'] }}">ID</a></th>
    <th><a href="/people?sort=name&order={{ $persons['order'] }}">Name</a></th>
    <th><a href="/people?sort=adress&order={{ $persons['order'] }}">Adress</a></th>
    <th><a href="/people?sort=phone&order={{ $persons['order'] }}">Phone</a></th>
    <th><a href="/people?sort=email&order={{ $persons['order'] }}">Email</a></th>
    <th><a href="/people?sort=company&order={{ $persons['order'] }}">Company</a></th>

    <th></th>
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($persons['persons'] as $company)

    <tr style="background-color: lightgrey">
        <td>{{ $company->id }}</td>
        <td><a href="/displayperson?id={{ $company->id }}">{{ $company->name }}</a></td>
        <td>{{ $company->adress }}</td>
        <td>{{ $company->phone }}</td>
        <td>{{ $company->email }}</td>
        <td>{{ $company->company }}</td>
        <td><a href="{{ route('person_show', $company->id) }}"><button type="submit" class="btn btn-info">Info</button></a></td>
        <td><a href="{{ route('person_edit', $company->id) }}"><button type="submit" class="btn btn-warning">Edit</button></a></td>
        <td><a href="{{ route('person_delete', $company->id) }}"><button type="submit" class="btn btn-danger">Delete</button></a></td>
    </tr>

    @endforeach

</tbody>
</table>
{{ $persons['persons']->links() }}

<form method="GET" action="/company" style="text-align: center;">
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
    <div><h4>Total Rows: {{ count($persons['total']) }}</h4></div>
    @endsection

