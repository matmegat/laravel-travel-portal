@extends('layouts.master')

@section('content')

<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Signed up at</th>
        <th>Activated?</th>
        <th>Group</th>
        <th>Action</th>
    </tr>

@foreach($users as $user)

    <tr>
        <td>{{$user->id}}</td>
        <td>
            <a title="Edit" href="{{ action('UserController@edit', array('id' => $user->id)) }}">
                {{$user->first_name}} {{$user->last_name}}
            </a>
        </td>
        <td>
            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
        </td>
        <td>{{$user->created_at}}</td>
        <td>@if($user->activated) Yes @else No @endif</td>
        <td>
            @foreach($user->groups as $group)
                {{ $group->name }}
            @endforeach
        </td>
        <td>
            <a title="Edit" href="{{ action('UserController@edit', array('id' => $user->id)) }}">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a onclick="return confirm('Are you sure want to delete this user?')" title="Delete" href="{{ action('UserController@delete', array('id' => $user->id)) }}">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </td>
    </tr>

@endforeach

    <tr>
        <td colspan="7">
            <a href="{{ action('UserController@create') }}"><i class="fa fa-dashboard fa-fw"></i> Add New User</a>
        </td>
    </tr>

</table>

{{ $users->links('admin.pagination') }}

@stop