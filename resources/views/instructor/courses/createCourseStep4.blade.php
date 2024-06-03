@extends('layouts.front')
@section('content')

@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif

<section class="grey section course-create-step4">
  <div class="container">
    <div class="row">
      <div id="content" class="col-md-12 col-sm-12 col-xs-12">
        <div class="blog-wrapper">
          <div class="row second-bread">
            <div class="col-md-12 steps">
              <div>
                <h1> <a href="{{ route('instructor.courses.createStep1') }}"> {{ __('Step 1') }} </a> </h1>
              </div>
              <div>
                <h1><a href="{{ route('instructor.courses.createStep2') }}">{{ __('Step 2') }}</a> </h1>
              </div>
              <div>
                <h1> <a href="{{ route('instructor.courses.createCourseStep3') }}"> {{ __('Step 3') }} </a> </h1>
              </div>
              <div>
                <h1 style="color: red;"><a href="{{ route('instructor.courses.createCourseStep4') }}"> {{ __('Step 4') }} </a> </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="blog-wrapper">
          <div class="blog-desc">
            <div class="shop-cart">
              <div class="edit-profile">
                <form action="{{ route('instructor.courses.store') }}" method="post">
                  @csrf
                <div class="">
                  <div class="ml-3">
                    <img height="100" class="course-image" id="course-image" src="#" alt="{{__('Choose image')}}" />
                  </div>
                  <div class="form-group">
                    <input type="file" style="width: 500px" class="form-control @error('courseImg64') is-invalid @enderror" name="image" id="course-image-file">
                  </div>
                  <input type="hidden" name="courseImg64" id="courseImg64" value="">

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
    <a href="{{ route('instructor.courses.createCourseStep3') }}" class="btn btn-primary">{{ __('Previous') }}</a>
  </div>
  <div>
    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
  </div>
  </form>

</section>
@endsection
@section('js')
<script src="{{ asset('front-assets/js/courses.js') }}"></script>
@endsection