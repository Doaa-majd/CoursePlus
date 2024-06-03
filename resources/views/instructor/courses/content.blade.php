@extends('layouts.front')

@section('content')
@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif
<section class="section course-edit">
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
      <div class="col-md-9 course-sections">
        <div class="add-section">
          <i class="fa fa-plus"></i> {{__('Add Section')}} </a>
        </div>
        @foreach($course->sections as $section)
        <section class="section">
          <div class="section-actions">
            <a href="#" data-toggle="modal" data-target="#addsection" data-sectionId="{{$section->id}}" id="{{$course->id}}" data-name="{{$section->name}}" 
              class="edit-section"><i class="fa fa-edit"  style="font-size:20px;"></i></a>
            <a href="#" id="{{$section->id}}" data-url="{{ route('admin.sections.delete', [$section->id])}}" 
              class="delete-section"><i class="fa fa-times" style="font-size:20px;"></i></a>
          </div>
          <div class="section-course-title">
            <h3>{{$section->name}}</h3>
          </div>
          <div class="section-lessons">
          @if($section->lessones)
          @foreach($section->lessones as $lesson)
            <div class="lesson">
              <div class="lesson-name">
              {{$lesson->name}}
              </div>
              <div class="lesson-action2" style="display:none">
                <a href="#" data-toggle="modal" data-target="#addsection" data-sectionId="{{$section->id}}" id="{{$course->id}}" data-name="{{$section->name}}" 
                    class="edit-section"><i class="fa fa-edit" style="font-size:20px;"></i></a>
                <a href="#" id="{{$section->id}}" data-url="{{ route('admin.sections.delete', [$section->id])}}" 
                    class="delete-section"><i class="fa fa-times" style="font-size:20px;"></i></a>
              </div>
            </div>
          @endforeach
          @endif
          </div>
          <div class="lesson-actions">
            <a href="#" data-toggle="modal" data-target="#addlecture" data-sid="{{$section->id}}" 
            class="add-lecture-modal"><i class="fa fa-plus"></i> {{__('Video')}} </a>

            <a href="#" data-toggle="modal" data-target="#addpdf" data-sid="{{$section->id}}" 
            class="add-pdf-modal"><i class="fa fa-plus"> </i> {{__('Document')}} </a>

            <a href="#" data-toggle="modal" data-target="#addpdf" data-sid="{{$section->id}}" 
            class="add-pdf-modal"><i class="fa fa-plus"> </i> {{__('Quize')}} </a>
          </div>
        </section>
        @endforeach
      </div>
    </div>
  </div>
</section>

@endsection

@section('js')
<script src="{{ asset('front-assets/js/courses.js') }}"></script>
@endsection