@extends('layouts.instructor')

@section('content')

<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800">{{__('All Courses')}}</h2>
  <div class="ml-auto">
    <a href="{{ route('instructor.courses.createStep1')}}" class="btn btn-outline-info btn-sm">{{__('New Course')}}</a>
  </div>
</div>
<div class="action">
  <input type="checkbox" id="master">
  <a href="#" class="delete_all mb-2" data-table="courses"
    data-url="{{ route('admin.categories.deleteAll')}}">{{__('Delete')}}</a>

    <div class="container">
        <div class="row">
        @foreach($courses as $key => $course)

            <div class="col-md-3 course-info">
                <div class="course-img"><img height="" src="{{ asset('images/' . $course->image) }}">
                    <input type="checkbox" class="sub_chk" data-id="{{$course->id}}">
                    <div class="overlay">
                        <div class="buttons">
                            <a href="{{ route('admin.courses.show', [$course->id])}}"> <i class="fas fa-fw fa-edit"></i></a>
                            <a href="#" data-url="{{ route('admin.courses.delete', [$course->id])}}"><i class="fas fa-fw fa-trash"></i></a>
                        </div>
                    </div>

            </div>
            <div class="course-title">{{$course->title}}</div>

            </div>
        @endforeach
        </div>
    </div>


</div>


@endsection