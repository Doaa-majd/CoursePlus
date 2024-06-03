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
                <h1><a href="{{ route('instructor.courses.createStep2') }}">{{ __('Step 2') }}</a> </h1>
              </div>
              <div>
                <h1 style="color: red;"><a href="{{ route('instructor.courses.createCourseStep3') }}"> {{ __('Step 3') }} </a> </h1>
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
                <form action="{{ route('instructor.courses.createCourseStep4') }}" method="get">
                  <div class="form-group">
                    <label>{{__('Category')}} <span style="color:red">*</span></label>
                    <select id="category_id" name="category_id" class="form-control custom-select @error('category_id') is-invalid @enderror">
                      <option value="">-- {{__('Select Category')}} --</option>
                      @foreach($categories as $category)
                      <option @if ($category->id == old('category_id')) selected @endif value="{{$category->id}}"
                        @if(Session::has('category_id') && Session::get('category_id') == $category->id) selected @endif>{{$category->name}}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>{{__('Language')}} <span style="color:red">*</span></label>
                    <select id="lang" name="languge" class="form-control @error('languge') is-invalid @enderror">
                      <option value="">-- {{__('Select language')}} --</option>
                      <option @if (old('languge')=='en') selected @endif @if(Session::has('languge') && Session::get('languge') == 'en') selected @endif value="en">{{__('English')}}</option>
                      <option @if (old('languge')=='ar') selected @endif @if(Session::has('languge') && Session::get('languge') == 'ar') selected @endif value="ar">{{__('Arabic')}}</option>
                    </select> 
                  </div>
                  @error('languge')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <div class="form-group">
                    <label>{{__('Price')}}</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" 
                      value="{{ old('price') }} @if(Session::has('price')) {{session()->get('price')}} @endif" id="price" placeholder="price">
                    <span>{{ __('Price in dollar, let it empty if the course free') }}</span>
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
    <a href="{{ route('instructor.courses.createStep2') }}" class="btn btn-primary">{{ __('Previous') }}</a>
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