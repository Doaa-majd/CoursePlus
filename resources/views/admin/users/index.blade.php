@extends('layouts.admin')
@section('title', __('Users') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('Users')}} </h2>
  <div class="ml-auto">
  </div>
</div>

<table class="table mt-3">
  <tr>
    <th> {{__('No')}} </th>
    <th> {{__('Name')}} </th> 
    <th> {{__('Email')}} </th>
    <th>{{__('Type')}} </th>
    <th>{{__('Created At')}} </th>
    <th> {{__('Actions')}} </th>

  </tr>
  @foreach($users as $key => $user)
  <tr>
    <td>{{ ++$key }}</td>
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->role}}</td>
    <td>{{$user->created_at->diffForHumans()}}</td>
    <td>
      <div class="d-flex">
      <a href="#" class="btn btn-outline-success mr-1 btn-sm"> {{__('Show')}} </a> 
      <a href="#" data-url="{{ route('admin.users.delete', [$user->id])}}"  class="btn btn-outline-danger btn-sm delete-user">{{__('Delete')}} </a> 
      </div>
    </td>
  </tr>
  @endforeach

</table>

{{ $users->links() }}


@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection