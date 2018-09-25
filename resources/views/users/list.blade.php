@extends('layouts.app')

@section('content')

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@can('manage', $model)
<td><a href="{{ route('roles_manage') }}"><button type="button" class="btn btn-info" style="width:100%; margin-bottom: 20px;">{{trans('company.roles_manage')}}</button></a></td>
@endcan

@can('create', $model)
<a href="{{ route('user_create') }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.add')}}</button></button></a>
@endcan

<button type='button' class='btn btn-info' id='filters' style="display: flex;"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
<form method='GET' class="form-horizontal" id='searchForm' action='/users' style="margin-top: 10px; margin-bottom: 10px; display: none;">
    <div class="col-md-2">
        <input type="text" class="form-control" name="searchUser[username]" placeholder="{{trans('company.searchByUsername')}}" value="">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-info">{{trans('company.search')}}</button>
    </div>
</form>
<table class="table table-striped">
    <thead>
    <th><a href="/users?sort=id&order={{ $users['order'] }}">ID</a></th>
    <th>{{trans('company.avatar')}}</th>
    <th><a href="/users?sort=username&order={{ $users['order'] }}">{{trans('company.username')}}</a></th>
    <th><a href="/users?sort=email&order={{ $users['order'] }}">{{trans('company.email')}}</a></th>
    <th><a href="/users?sort=role&order={{ $users['order'] }}">{{trans('company.role')}}</a></th>
    @can('activate', $model)
    <th><a href="/users?sort=active&order={{ $users['order'] }}">{{trans('company.active')}}</a></th>
    @endcan
    <th></th>
    <th></th>
</thead>

<tbody>
    @foreach ($users['users'] as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td><img src="{{ url('/') }}/uploads/avatars/{{$user->username}}/{{ $user->avatar }}" style="width: 45px; max-height: 40px; border-radius: 89%;"></td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>
            @if ($user->active == 1)
            <div id="active"> 
                @can('deactivate', $model)
                <a href="{{ route('user_deactivate', $user->id) }}" onclick="return confirm('Are you sure you want to deactivate this user?')"><i class="fa fa-check-circle"></i></a>
                @endcan
            </div>
            @else
            @can('activate', $model)
            <a href="{{ route('user_activate', $user->id) }}" onclick="return confirm('Are you sure you want to activate this user?')"><i class="fa fa-circle"></i></a>
            @endcan    
            @endif
        </td>
        @can('edit', $model)
        <td><a href="{{ route('user_edit', $user->id) }}"><button type="submit" class="btn btn-warning">{{trans('company.edit')}}</button></a></td>
        @endcan
        @can('upload', $model)
        <td><a href="{{ route('user_upload', $user->id) }}"><button type="submit" class="btn btn-info">{{trans('company.upload_avatar')}}</button></a></td>
        @endcan
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
    <div><h4>{{trans('company.totalRows')}} {{ $users['users']->total() }}</h4></div>
</form>

<script>
    $(document).ready(function () {

        $('#filters').click(function () {
            $('#searchForm').toggle();
        });
    });
</script>
@endsection

