 @extends('layouts.app')

@section('content')   
{!! Form::open(array('route' => 'user_manage', 'method'=>'post')) !!}
{{ Form::hidden('role_id', $roleName[0]->id) }}
<div class="form-group row" style="text-align: center">
        <h1>
            <label for="role">{{trans('company.choose_role')}}  {{$roleName[0]->name }} </label>
        </h1>
        <br>       
        @foreach($permissions['allPermissions'] as $groupPermission => $permissionsByGroup)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $groupPermission }}</h3>
                </div>
                <div class="panel-body">
                        @foreach($permissionsByGroup as $permission)
                        <?php $string =  strstr($permission->name, '_');
                            $string = substr($string, 1);?>
                        
                            {!! Form::checkbox('permissionForAdmin[]', $permission->id, in_array($permission->id, $permissions['rolePermissions']), ['class' => 'form-control']) !!} {{ ucfirst($string) }}<br>
                        @endforeach
                 </div>
            </div>
        @endforeach
    </div>
{!! Form::submit('Submit', array('class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 5px;')) !!}
{!! Form::close() !!}
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>
@endsection