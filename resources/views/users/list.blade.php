@extends('layouts.app')

@section('content')

<a href="{{ route('user_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">Add</button></button></a>

<form method='GET' class="form-horizontal" action='/users' style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchUser[username]" placeholder="Search by Name.." value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">Search</button>
    </div>
</form>
<table class="table table-striped">
    <thead>
    <th><a href="/users?sort=id&order={{ $users['order'] }}">ID</a></th>
    <th>Avatar</th>
    <th><a href="/users?sort=username&order={{ $users['order'] }}">Name</a></th>
    <th><a href="/users?sort=email&order={{ $users['order'] }}">E-mail</a></th>
    <th><a href="/users?sort=active&order={{ $users['order'] }}">Active</a></th>
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($users['users'] as $user)
    <tr style="background-color: lightgrey">
        <td>{{ $user->id }}</td>
        <td><img src="{{ url('/') }}/uploads/avatars/{{$user->username}}/{{ $user->avatar }}" style="width: 45px; max-height: 40px; border-radius: 89%;"></td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if ($user->active == 1)
            <div id="active">
                
                <a href="{{ route('user_deactivate', $user->id) }}"><i class="fa fa-check-circle"></i></a>
            </div>
            @else
            <a href="{{ route('user_activate', $user->id) }}"><i class="fa fa-circle"></i></a>
                
            @endif
        </td>
        <td><a href="{{ route('user_edit', $user->id) }}"><button type="submit" class="btn btn-warning">Edit</button></a></td>
        <td><a href="{{ route('user_upload', $user->id) }}"><button type="submit" class="btn btn-info">Upload Avatar</button></a></td>
    </tr>

    @endforeach
</tbody>
</table>
{{ $users['users']->links() }}

<form method="GET" action="/users" style="text-align: center;">
    <select name="option" style="margin-right: 2px;">

        <?php $perPageOptions = [5, 10, 15, 20] ?>
        @foreach ($perPageOptions as $perPageOption) 
        @if ($perPageOption == $users['perPage'])
        <option selected="selected" value="{{ $perPageOption }}" >{{ $perPageOption }}</option>
        @else
        <option value="{{ $perPageOption }}" >{{ $perPageOption }}</option>

        @endif

        @endforeach
    </select>
    <input type="submit" class="btn btn-info" style="margin-left: 2px;"></button>
    <div><h4>Total Rows: {{ $users['users']->total() }}</h4></div>
</form>
@endsection

