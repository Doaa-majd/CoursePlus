@extends('layouts.admin')
@section('title', __('Payout'))
@section('content')

@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> {{__('Your Earning')}} </h1>
    <div class="ml-auto">
      <a href="#" data-toggle="modal" data-target="#withdraw" class="btn btn-outline-info btn-sm"> {{__('Withdraw')}} </a>
    </div>
    </div>

    @if($payouts)
    <table class="table mt-3">
        <tr>
          <th width="400px">{{__('Course Name')}}</th>
          <th width="300px">{{__('No of sales')}}</th>
          <th>{{__('Total Price $')}}</th>
          <th>{{__('Total after commission $')}}</th>

          
        </tr>
        @foreach($payouts as $key => $payout)

        <tr class="item-row">
          <td>{{ $payout['name']}}  </td>
          <td>{{$payout['sales_number'] }}</td>
          <td>{{$payout['price'] }} </td>
          <td>{{$payout['total_price_after_commission']}} </td>
        </tr>
        @endforeach
        <tr class="item-row" style="background-color: #eee">
          <td> {{__('Your Total earning from courses')}}  </td>
          <td></td>
          <td> </td>
          <td>{{$total_earning}} $ </td>
        </tr>
      </table>

     @if(Auth::user()->role == 'admin')
      <h6> {{__('Your Total earning from Commissions')}} = {{$admin_commission}} $</h6>
      <h6> {{__('Your Total earning')}}  = {{$admin_total}} $</h6>
      @endif
      <h6> {{__('Current earning you can withdraw')}} = {{$current_earning}} $</h6>
      @else 
      {{__('There is no payout yet')}}
     @endif

<!-- Modal for withdraw process-->
<div class="modal fade" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('Withdraw')}} </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
          <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">{{__('Amount number')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control amount" name="amount" value=""  placeholder="you can withraw {{$current_earning}} $ or less ">

              </div>
          </div>
          <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">{{__('Paypal Email')}}</label>
              <div class="col-sm-10">
                <input type="email" class="form-control email" name="email" value=""  placeholder="Your valied paypal email">

              </div>
              
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <a data-url="{{ route('paypal.withdraw.store')}}" class="btn btn-primary withdraw">{{__('Withdraw')}}</a>
      </div>
  
    </div>
  </div>
</div>


@endsection

@section('js')
<script src="{{ asset('js/payout.js') }}"></script>

@endsection