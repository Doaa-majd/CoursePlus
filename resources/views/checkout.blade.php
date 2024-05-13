@extends('layouts.front')
@section('content')

<section class="grey section">
    <div class="container">
        <div class="row">
            <div id="content" class="col-md-12 col-sm-12 col-xs-12">
                <div class="blog-wrapper">
                    <div class="row second-bread">
                        <div class="col-md-6 text-left">
                            <h1> {{__('Cart &amp; Checkout')}} </h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="bread">
                                <ol class="breadcrumb">
                                    <li><a href="#"> {{__('Home')}} </a></li>
                                    <li class="active">{{__('Checkout')}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-wrapper">
                    <div class="row">
                        <div class="col-md-7 text-left">
                            <div class="blog-desc">
                                <div class="shop-cart">

                                    <hr class="invis">
                                    <div class="edit-profile">
                                        <form role="form" action=" {{ route('checkout.store') }} " method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>{{__('First Name')}}</label>
                                                <input type="text" value=" {{$user->profile->fname}} " class="form-control" placeholder="Amanda">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Last Name')}}</label>
                                                <input type="text" value=" {{$user->profile->lname}} " class="form-control" placeholder="FOX">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Email Address')}}</label>
                                                <input type="email" class="form-control" value=" {{$user->email}} "
                                                    placeholder="name@learnplus.com">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Address')}}</label>
                                                <input type="text" value=" {{$user->profile->address}} " class="form-control" placeholder="Al Nasser street">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Country')}}</label>
                                                <input type="text" value=" {{$user->profile->country}} " class="form-control" placeholder="Palestine">
                                            </div>
                                           
                                            <hr class="invis">
                                            <div class="payment-check">
                                                <p><strong>{{__('Select Payment Method')}}</strong></p>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked> {{__('Paypal')}}
                                                    </label>
                                                    &nbsp;&nbsp;

                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"> {{__('Place Order')}}</button>
                                        </form>
                                    </div>

                                    <hr class="invis">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-left">
                            <div class="blog-desc">
                                <div class="shop-cart">
                                    <hr class="invis">
                                    <div class="">
                                        <strong>{{__('Your Order')}}</strong>
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        {{__('Item Name')}}
                                                    </th>
                                                    <th>
                                                        {{__('Price')}} ($)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $total = 0;
                                                @endphp
                                                @foreach($cart as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->course->title }}
                                                    </td>
                                                    <td>
                                                        {{ $item->price }}
                                                    </td>
                                                </tr>
                                                @php
                                                $total += $item->price ;
                                                @endphp
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                        <div class="well total-price">
                                            <p><strong> {{__('Purchase Total:')}}</strong> ${{$total}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection