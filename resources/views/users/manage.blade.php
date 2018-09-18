 @extends('layouts.app')

@section('content')   
{!! Form::open(array('route' => 'user_manage', 'method'=>'post')) !!}
{{ Form::hidden('role_id', $roleName[0]->id) }}
<div class="form-group row" style="text-align: center">
    <h3> {{$roleName[0]->name }} </h3>
        <label for="role">{{trans('company.choose_role')}}</label><br>
        <?php $unique = ''; ?>
        @foreach($permissions['allPermissions'] as $permission)
            @if($unique !== $permission->permission_group)
            <?php $unique = $permission->permission_group; ?>
            <h4>{{ $permission->permission_group }}</h4>
            @endif
            
            <?php $unique = $permission->permission_group; ?>
            
            <?php $newString = strstr($permission->name, '_'); $newString = substr($newString, 1);?>
            @if(in_array($permission->id, $permissions['rolePermissionFlat']))
        <input type="checkbox" checked="" name="permissionForAdmin[]" value="{{ $permission->id }}">{{ ucfirst($newString) }}<br>     
            @else
         <input type="checkbox" name="permissionForAdmin[]" value="{{ $permission->id }}">{{ ucfirst($newString) }}<br>
            @endif
        @endforeach
    </div>
{!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>

@endsection