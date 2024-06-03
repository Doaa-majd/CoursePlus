@extends('layouts.front')

@section('content')
@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif
<section class="grey section course-create-step1">
  <div class="container">
    <div class="row">
      <div id="content" class="col-md-12 col-sm-12 col-xs-12">
        <div class="blog-wrapper">
          <div class="row second-bread">
            <div class="col-md-12 steps">
              <div>
                <h1><a style="color: red;" href="{{ route('instructor.courses.createStep1') }}"> {{ __('Step 1') }} </a> </h1>
              </div>
              <div>
                <h1> <a href="{{ route('instructor.courses.createStep2') }}">{{ __('Step 2') }} </a></h1>
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

              <div class="edit-profile text-center">
                <form action="{{ route('instructor.courses.createStep2') }}" method="get">
                
                  <div class="form-check course-type single @if(Session::has('type') && Session::get('type') == 'single session') active @endif">
                    <input class="form-check-input" type="radio" name="type" id="single-session" value="single session"
                    @if(Session::has('type') && Session::get('type') == 'single session') checked @endif">
                    <label class="form-check-label" for="single-session">
                      {{ __('Single session') }}
                    </label>
                  </div>
                  <div class="form-check course-type complete @if(Session::has('type') && Session::get('type') == 'complete course') active @endif">
                    <input class="form-check-input" type="radio" name="type" id="complete-course" value="complete course"
                      @if(Session::has('type') && Session::get('type') == 'complete course') checked @endif">
                    <label class="form-check-label" for="complete-course">
                      {{__('Complete Course')}}
                    </label>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="action-buttons">
  <div>
  </div>
  <div>
    <button type="submit" class="btn btn-primary next-step1">{{ __('Next') }}</button>
  </div>
  </form>
</section>
@endsection

@section('js')
<script src="{{ asset('front-assets/js/courses.js') }}"></script>
@endsection