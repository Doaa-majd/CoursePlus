@extends('layouts.admin')
@section('title', __('Coupons') )
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('All Coupons')}} </h2>
  <div class="ml-auto">
    <a href="{{ route('admin.coupons.create')}}" class="btn btn-outline-info btn-sm">{{__('Create New Coupon')}}</a>
  </div>
</div>
<table class="table mt-3">
  <tr>
    <th>{{__('Code')}}</th>
    <th>{{__('Coupon Type')}}</th> 
    <th>{{__('Value')}}</th>
    <th>{{__('Max usage')}}</th>
    <th>{{__('Expired date')}}</th>
    <th>{{__('Created At')}}</th>
    <th>{{__('Actions')}}</th>
  </tr>
  @foreach($coupons as $key => $coupon)
  <tr>
    <td>{{$coupon->code}}</td>
    <td>{{$coupon->type}}</td>
    <td>{{$coupon->value}}</td>
    <td>{{$coupon->max_usage}}</td>
    <td>{{$coupon->expired_date}}</td>
    <td>{{$coupon->created_at->diffForHumans()}}</td> 
    <td>
      <div class="d-flex">
        <a href="{{ route('admin.coupons.edit', [$coupon->id])}}" class="btn btn-outline-success mr-1 btn-sm">{{__('Edit')}}</a> 
        <form method="post" action="{{ route('admin.coupons.delete', [$coupon->id])}}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger btn-sm">{{__('Delete')}}</button>
        </form>
      </div>
    </td>
  </tr>
  @endforeach

</table>
{{ $coupons->links() }}

@endsection