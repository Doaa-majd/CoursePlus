@extends('layouts.front')
@section('content')

@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<section class="grey section">
    <div class="container">
        <div class="row">
            <div id="content" class="col-md-12 col-sm-12 col-xs-12">
                <div class="blog-wrapper">
                    <div class="row second-bread">
                        <div class="col-md-6 text-left">
                            <h1> {{__('Cart Items:')}} </h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="bread">
                                <ol class="breadcrumb">
                                    <li><a href="#">{{__('Home')}}</a></li>
                                    <li class="active">{{__('Cart')}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-wrapper">
                    <div class="blog-desc">
                        <div class="shop-cart">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            {{__('Item Name')}}
                                        </th>
                                        <th>
                                            {{__('Item Price')}}  ($)
                                        </th>
                                        <th>
                                            {{__('Actions')}}
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
                                                <a href="{{ route('courses.show', [$item->course->id])}}">
                                                    <img src="{{ asset('images/'. $item->course->image ) }}" alt="" class="alignleft img-thumbnail">
                                                     {{ $item->course->title }}</a>
                                            </td>
                                            <td>
                                                {{ $item->price }}
                                            </td>
                                            <td class="remove">
                                                <a href="#" class="remove-item" data-price="{{ $item->price }}" 
                                                data-url="{{ route('carts.delete', [$item->id]) }}" data-id="{{ $item->course->id }}">Remove</a>
                                            </td>
                                        </tr>
                                        @php
                                           $total += $item->price ;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">
                                            {{__('Total:')}} $ <span class="cart-total"> {{$total }} </span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                           <a href=" {{ route('checkout.index')}} " class="btn btn-primary"> {{__('Process to checkout')}} </a>
                            <hr class="invis">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('js')
<script>
    $(document).on( 'click','.remove-item', function(e) {
        e.preventDefault();

        Swal.fire({
            title: titleDeleteMs,
            text: deleteText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: deleteOkBtn,
            cancelButtonText: deleteCancelBtn,    
      }).then((result) => {
        if (result.value) {
            var itemPrice = $(this).data('price');
            $.ajax({
                type: 'DELETE',
                url: $(this).data('url'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'course_id' : $(this).data('id'),
                },
                success: function() {  
                    $('.cart-total').html($('.cart-total').html() - itemPrice) ;
                }, 
            }); 
            $(this).parent().parent().fadeOut();     
        }
      })


    });  
</script>
@endsection