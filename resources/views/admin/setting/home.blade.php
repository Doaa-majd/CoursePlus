@extends('layouts.admin')
@section('title', __('Home Setting') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('Home Setting')}} </h2>
  <div class="ml-auto">
  </div>
</div>

<div class="row">

    <div class="col-lg-12">

        @foreach($settings as $setting)

            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    {{__($setting->name)}}
                </div>

                <div class="card-body row">
                    @if($setting->prefix == 'home_slider')
                    <div class="col-sm-4">
                       <input type="file" style="width: 320px" class="custom-file-input sliderFiles" name="image" data-id="{{$setting->id}}" id="sliderFiles">
                       <label style="width: 320px" class="custom-file-label" for="sliderFiles"> {{__('Choose image')}} </label>
                   </div>
                    <div class="col-sm-4">
                       <img height="100" width="200" id="slider-{{$setting->id}}" src="{{ asset('images/' . $setting->value) }}">                
                    </div>
                    <div class="col-sm-5">
                        <a data-url="{{ route('admin.settings.homeSlider.update', [$setting->id])}}" data-id="{{$setting->id}}" class="btn btn-outline-info update-slider"> {{__('Save')}} </a>
                    </div>
                    <input type="hidden" name="img64" id="img64-{{$setting->id}}" value="">
                    @endif

                    @if($setting->prefix == 'home_desc')
                     <div class="col-sm-5">
                            <textarea class="form-control {{$setting->id}}" rows="4" cols="50">{!!$setting->value !!}
                            </textarea>   
                    </div>
                    <div class="col-sm-5">
                        <a data-id="{{$setting->id}}" data-url="{{ route('admin.settings.home.update', [$setting->id])}}" class="btn btn-outline-info update-home"> {{__('Edit')}} </a>
                    </div>
                    @endif
                    @if($setting->prefix == 'home_title')
                    <div class="col-sm-5">
                    <input type="text" class="form-control {{$setting->id}}" value="{{$setting->value}}">
                    </div>
                    <div class="col-sm-5">
                        <a data-id="{{$setting->id}}" data-url="{{ route('admin.settings.home.update', [$setting->id])}}" class="btn btn-outline-info update-home"> {{__('Edit')}} </a>
                    </div>
                    @endif
                    
                </div>
            </div>
          @endforeach
    </div>

  </div>

@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection