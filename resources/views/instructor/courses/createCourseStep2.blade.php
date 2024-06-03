@extends('layouts.front')

@section('content')

@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif
<section class="grey section course-create-step2">
  <div class="container">
    <div class="row">
      <div id="content" class="col-md-12 col-sm-12 col-xs-12">
        <div class="blog-wrapper">
          <div class="row second-bread">
            <div class="col-md-12 steps">
              <div>
                <h1><a href="{{ route('instructor.courses.createStep1') }}"> {{ __('Step 1') }} </a> </h1>
              </div>
              <div>
                <h1 style="color: red;"><a href="{{ route('instructor.courses.createStep2') }}">{{ __('Step 2') }}</a></h1>
              </div>
              <div>
                <h1> <a href="{{ route('instructor.courses.createCourseStep3') }}"> {{ __('Step 3') }} </a> </h1>
              </div>
              <div>
                <h1><a href="{{ route('instructor.courses.createCourseStep4') }}"> {{ __('Step 4') }} </a> </h1>
              </div>
            </div>
            
          </div>
        </div>
        <div class="blog-wrapper">
          <div class="blog-desc">
            <div class="shop-cart">

              <div class="edit-profile">
                <form action="{{ route('instructor.courses.createCourseStep3') }}" method="get">
                  <div class="form-group">
                    <label>{{__('Course Title')}} <span style="color:red">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="@if(Session::has('title')) {{session()->get('title')}} @else {{ old('title') }} @endif" 
                        id="title" placeholder="Enter title ">
                  </div>
                  @error('title')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <div class="form-group">
                    <label>{{__('Sub Title')}} <span style="color:red">*</span></label>
                    <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" value="@if(Session::has('sub_title')) {{session()->get('sub_title')}} @else {{ old('sub_title') }} @endif" 
                      id="sub_title" placeholder="Enter sub title">
                    @error('sub_title')
                      <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>{{__('Description')}} <span style="color:red">*</span></label>
                    <textarea class="form-control" rows="6" id="description" value="{{ old('description') }}" name="description" @error('description') is-invalid @enderror">
                    @if(Session::has('description')) {{session()->get('description')}} @else {{ old('description') }} @endif
                    </textarea>
                    @error('description')
                      <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  
              </div>
              <hr class="invis">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="action-buttons">
  <div>
    <a href="{{ route('instructor.courses.createStep1') }}" class="btn btn-primary">{{ __('Previous') }}</a>
  </div>
  <div>
    <button type="submit" class="btn btn-primary">{{ __('Next') }}</button>
  </div>
  </form>

</section>
@endsection
@section('js')
<script src="{{ asset('front-assets/js/courses.js') }}"></script>
@endsection