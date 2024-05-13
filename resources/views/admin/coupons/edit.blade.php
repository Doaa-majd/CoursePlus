@extends('layouts.admin')
@section('title', __('Update Coupon') )
@section('content')

@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
</div>
@endforeach
@endif

<h2 class="text-center"> {{__('Update Coupon')}} </h2>
<div class="mx-auto mt-5 mx-rtl" style="width: 500px;">
    <form action="{{ route('admin.coupons.update', $coupon->id)}}" method="post">
        @csrf
        @method('put')
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">{{__('Code')}}</label>
                <input type="text" class="form-control code @error('code') is-invalid @enderror" name="code"
                    value="{{ old('code', $coupon->code) }}" id="code" placeholder="random code">
                @error('code')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <button type="submit" data-url="{{ route('admin.coupons.generate')}}" 
                class="btn btn-outline-primary btn-sm generate-code">{{__('Generate')}}</button>
            </div>
        </div>

        <div class="form-group">
            <label for="courses">{{__('Courses for this coupon')}}</label>
            <select id="courses" name="courses[]" class="custom-select @error('courses') is-invalid @enderror coupon-courses" multiple="true">
            @foreach($courses as $course)
                <option value="{{$course->id}}"> {{$course->title}} </option>
            @endforeach
            </select>
            @error('type')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="type">{{__('Coupon Type')}}</label>
            <select id="type" name="type" class="custom-select @error('type') is-invalid @enderror">
                <option value=""> -- </option>
                <option value="fixed" @if ($coupon->type == 'fixed') selected @endif> {{__('Fixed')}} </option>
                <option value="percentage" @if ($coupon->type == 'percentage') selected @endif> {{__('Percentage')}} </option>
            </select>
            @error('type')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group fixed">
            <label for="name">{{__('Value')}}</label>
            <input type="text" class="form-control @error('value') is-invalid @enderror" name="value"
                value="{{ old('value', $coupon->value) }}" id="value" placeholder="value">
            @error('value')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group max-usage">
            <label for="name">{{__('Max usage')}} </label>
            <input type="text" class="form-control @error('max_usage') is-invalid @enderror" name="max_usage"
                value="{{ old('max_usage', $coupon->max_usage) }}" id="percent_off" placeholder="max usage">
            @error('max_usage')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">{{__('Expired date')}}</label>
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date"
                value="{{ old('expired_date', $coupon->expired_date) }}" id="expired_date" placeholder="">
            @error('expired_date')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary mt-4">{{__('update')}}</button>
    </form>
</div>
@endsection


@section('js')
<script>
    $(document).on( 'change', '#type', function() {
        if($(this).val() =='fixed'){
            $('.fixed').show();
            $('.percentage').hide();
        }else{
            $('.fixed').hide();
            $('.percentage').show();
        }
    });

    $(document).on( 'click', '.generate-code', function(e) {
        e.preventDefault();
        $.ajax({
        type: 'get',
        url: $(this).data('url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {           
        },
        success: function(data) {
           $('.code').val(data.code);
        },
    }).fail(function (jqXHR, textStatus, error) {
        Swal.fire({
          icon: 'error',
          title:  errorTitle,
          text: jqXHR.responseText,
          footer: errorFooter
        })
    });	

    });
</script>

@endsection