@extends('layouts.admin')
@section('title', __('Orders') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('Orders')}} </h2>
  <div class="ml-auto">
  </div>
</div>

<table class="table mt-3">
  <tr>
    <th> {{__('No')}} </th>
    <th> {{__('By user')}} </th> 
    <th> {{__('Email')}} </th>
    <th>{{__('Status')}} </th>
    <th>{{__('Created at')}} </th>
    <th> {{__('Actions')}} </th>

  </tr>
  @foreach($orders as $key => $order)
  <tr>
    <td>{{ ++$key }}</td>
    <td>{{$order->user->name}}</td>
    <td>{{$order->user->email}}</td>
    <td>{{$order->status}}</td>
    <td>{{$order->created_at}}</td>
    <td>
      <div class="d-flex">
      <a href="{{ route('admin.orders.show', [$order->id])}}" class="btn btn-outline-success mr-1 btn-sm"> {{__('Show')}} </a> 
      <a href="#" data-url="{{ route('admin.orders.delete', [$order->id])}}"  class="btn btn-outline-danger btn-sm delete-order">{{__('Delete')}} </a> 
      </div> 
    </td>
  </tr>
  @endforeach

</table>

{{ $orders->links() }}


@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection