@extends('layouts.admin')
@section('title', __('About Setting') )
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800"> {{__('About Setting')}} </h2>
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
                     <div class="col-sm-5">
                            <textarea class="form-control {{$setting->id}}" rows="5" cols="70">{!!$setting->value !!}
                            </textarea>   
                    </div>
                    <div class="col-sm-5">
                        <a data-id="{{$setting->id}}" data-url="{{ route('admin.settings.about.update', [$setting->id])}}" class="btn btn-outline-info update-about"> {{__('Edit')}} </a>
                    </div>
                
                    
                </div>
            </div>
          @endforeach
    </div>

  </div>

@endsection

@section('js')
<script src="{{ asset('js/ad-process.js') }}"></script>
@endsection