@extends('layouts.frontInstructor')

@section('content')
@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif
<section class="grey section course-edit">
  <div class="container">
    <div class="row">
      <div id="sidebar" class="col-md-3 col-sm-12">
        <ul class="course-details">
          <li><a href="#step1">{{ __('Title') }}</a></li>
          <li><a href="#step1">{{ __('Sub title') }}</a></li>
          <li><a href="#step1">{{ __('Description') }}</a></li>
          <li><a href="#step2">{{ __('Category') }}</a></li>
          <li><a href="#step2">{{ __('Language') }}</a></li>
          <li><a href="#step2">{{ __('Price') }}</a></li>
          <li><a href="#step3">{{ __('Image') }}</a></li>
          <li><a href="{{ route('instructor.courses.lessons.show', $course->id) }}">{{ __('Lessons') }}</a></li>
        </ul>       
      </div>
      <div class="col-md-9 course-content">
        <div class="course-step1" id="step1">
          <div class="edit-icon-step1">
            <i class="fa fa-pencil" style="font-size:18px;"></i>
          </div>
          <div class="step1-details">
            <div>
              <label for="">{{ __('Title') }}</label>
              <div class="course-title">{{ $course->title }}</div>
            </div>
            <div>
              <label for="">{{ __('Sub title') }}</label>
              <div class="course-sub-title">{{ $course->sub_title }}</div>
            </div>
            <div>
              <label for="">{{ __('Description') }}</label>
              <div class="course-description">{{ $course->description }}</div>
            </div>
          </div>
          <div class="edit-step1" style="display:none;">
            <div class="form-group">
              <label for="title">{{__('Title')}}</label>
              <input type="text" id="title" class="form-control title" value="{{ $course->title }}">
            </div>
            <div class="form-group">
              <label for="sub_title">{{__('Sub title')}}</label>
              <input type="text" id="sub_title" class="form-control sub_title" value="{{ $course->sub_title }}">
            </div>
            <div class="form-group">
              <label for="description">{{__('Description')}}</label>
              <textarea id="description" class="form-control description"> {{ $course->description }}</textarea>
            </div>
            
            <div class="edit-step1-action">
              <a href="#" class="btn btn-primary cancel-step1-btn">Cancel</a>
              <a href="#" data-url="{{ route('instructor.courses.update', [$course->id]) }}" class="btn btn-primary edit-step1-btn">Edit</a>
            </div>
          </div>
        </div>
        <hr>
        <div class="course-step2" id="step2">
          <div class="edit-icon-step2">
            <i class="fa fa-pencil" style="font-size:18px;"></i>
          </div>
          <div class="step2-details">
            <div>
              <label for="">{{ __('Category') }}</label>
              <div class="course-category">{{ $course->category->name }}</div>
            </div>
            <div>
              <label for="">{{ __('Language') }}</label>
              <div class="course-languge">{{ $course->languge }}</div>
            </div>
            <div>
              <label for="">{{ __('Price') }}</label>
              <div class="course-price">{{ $course->price }} $</div>
            </div>

          </div>
          <div class="edit-step2" style="display:none;">
            <div class="form-group">
              <label class="" for="category_id">{{__('Category')}} </label>
              <select id="category_id" name="category_id" class="form-control category_id @error('category_id') is-invalid @enderror">
                <option value="">-- {{__('Select Category')}} --</option>
                @foreach($categories as $category)
                <option @if ($category->id == $course->category_id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                
              </select>
            </div>
            <div class="form-group">
              <label for="languge">{{__('Language')}}</label>
                <select id="languge" name="languge" class="form-control languge @error('languge') is-invalid @enderror">
                    <option value="">-- {{__('Select language')}} --</option>
                    <option @if ($course->languge =='en' ) selected @endif value="en">{{__('English')}} </option>
                    <option @if ($course->languge =='ar') selected @endif value="ar">{{__('Arabic')}} </option>
                </select> 
            </div>
            <div class="form-group">
              <label for="price">{{__('Price')}}: in $</label>
              <input type="text" class="form-control price" value="{{$course->price}}">
            </div>
            
            <div class="edit-step2-action">
              <a href="#" class="btn btn-primary cancel-step2-btn">Cancel</a>
              <a href="#" data-url="{{ route('instructor.courses.update', [$course->id]) }}" class="btn btn-primary edit-step2-btn">Edit</a>
            </div>
          </div>
        </div>
        <hr>
        <div class="course-step3" id="step3">
          <label for="">{{ __('Image') }}</label>
          <div><img height="300" class="image course-image" src="{{ asset('images/' . $course->image) }}"></div>
          <div class="form-group d-flex">
            <input type="file" style="width: 250px" class="form-control @error('courseImg64') is-invalid @enderror" 
              name="image" id="course-image-file">
            <a href="#" style="margin-left:5px;margin-left:5px;" class="btn btn-primary upload-course-image">Upload</a>
          </div>
          <input type="hidden" name="courseImg64" id="courseImg64" value="">
        </div>
        <hr>
      </div>
    </div>
  </div>
</section>

@endsection

@section('js')
<script src="{{ asset('front-assets/js/courses.js') }}"></script>
@endsection