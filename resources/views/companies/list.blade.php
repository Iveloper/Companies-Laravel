@extends('layout.main')

@section('content')
<a href="company/companyadd/"><button type="button" class="btn btn-primary" style="width:100%;">Add</button></a>


<form method='GET' class="form-horizontal" action='/company' style="width:2260px; margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[name]" placeholder="Search by Name.." value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[adress]" placeholder="Search by Adress.." value="">
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchCompany[bulstat]" placeholder="Search by Bulstat.." value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">Search</button>
    </div>
</form>

<table class="table table-striped">
    <thead>
    <th><a href="/company?sort=id&order={{ $companies['order'] }}">ID</a></th>
    <th><a href="/company?sort=name&order={{ $companies['order'] }}">Name</a></th>
    <th><a href="/company?sort=adress&order={{ $companies['order'] }}">Adress</a></th>
    <th><a href="/company?sort=bulstat&order={{ $companies['order'] }}">Bulstat</a></th>
    <th><a href="/company?sort=note&order={{ $companies['order'] }}">Note</a></th>
    <th></th>
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($companies['companies'] as $company)

    <tr style="background-color: lightgrey">
        <td>{{ $company->id }}</td>
        <td><a href="/displayperson?id={{ $company->id }}">{{ $company->name }}</a></td>
        <td>{{ $company->adress }}</td>
        <td>{{ $company->bulstat }}</td>
        <td>{{ $company->note }}</td>
        <td><a href="company/companyrecord/id/{{ $company->id }}"><button type="submit" class="btn btn-info">Info</button></a></td>
        <td><a href="{{ route('company_edit', $company->id) }}"><button type="submit" class="btn btn-warning">Edit</button></a></td>
        <td><a href="company/companydelete/id/{{ $company->id }}"><button type="submit" class="btn btn-danger">Delete</button></a></td>
    </tr>

    @endforeach

</tbody>
</table>
{{ $companies['companies']->links() }}

<form method="GET" action="/company">
    <select name="option">

        <?php $perPageOptions = [5, 10, 15, 20] ?>
        @foreach ($perPageOptions as $perPageOption) 
        @if ($perPageOption == $companies['perPage'])
        <option selected="selected" value="{{ $perPageOption }}" >{{ $perPageOption }}</option>
        @else
        <option value="{{ $perPageOption }}" >{{ $perPageOption }}</option>
        
        @endif

        @endforeach
        <input type="submit"class="btn btn-info"></button>
    </select>
    <div><h4>Total Rows: {{ $companies['companies']->total() }}</h4></div>
    @endsection