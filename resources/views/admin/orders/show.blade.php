@extends('layouts.admin')
@section('title', __('Order details') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('Order details')}} </h2>
  <div class="ml-auto">
  </div>
</div>

<table class="table mt-3">
  <tr>
    <th> {{__('Order id')}} </th> 
    <th> {{__('Course name')}} </th>
    <th>{{__('Price')}} </th>
    <th>{{__('Price  after commission')}} </th>
    <th> {{__('Discount')}} </th>

  </tr>
  @foreach($orders as $order)
  <tr>
    <td>{{$order->order_id}}</td>
    <td>{{$order->course_name}}</td>
    <td>{{$order->price}}</td>
    <td>{{$order->priceAC}}</td>
    <td>{{$order->discount}}</td>
    
  </tr>
  @endforeach

</table>

{{ $orders->links() }}


@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection