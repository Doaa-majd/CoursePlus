@extends('layouts.admin')
@section('title', __('General Setting') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('General Setting')}} </h2>
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
                    @if($setting->name == 'commission')
                     <div class="col-sm-4">
                        <input type="text" class="form-control commission" name="{{$setting->name}}" value="{{$setting->value}}">
                     </div>
                     <div class="col-sm-4">
                        % {{__('per course purchase')}}                
                     </div>
                     @endif

                     @if($setting->name == 'Site logo')
                     <div class="col-sm-4">
                        <input type="file" style="width: 320px" class="custom-file-input" name="image" id="customFile">
                        <label style="width: 320px" class="custom-file-label" for="customFile"> {{__('Choose image')}} </label>
                    </div>
                     <div class="col-sm-4">
                        <img height="50" width="212" id="logo-img" src="{{ asset('images/' . $setting->value) }}">                
                     </div>
                     <input type="hidden" name="img64" id="img64" value="">
                     @endif
                </div>
            </div>
          @endforeach
          <a data-url="{{ route('admin.settings.general.update')}}" class="btn btn-outline-info update-general"> {{__('Edit')}} </a>
    </div>

  </div>

@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection