@extends('layouts.front')
@section('title', __('My Profile') )
@section('content')

<section class="white profile-section">
    <div class="container">
        <div class="row">
            <div class="cover-img">
                <img class="" src="{{ asset('images/' . $profile['cover_image']) }}" alt="" id="cover-image" class="">
            </div>
        </div>
        <div class="row">
            <div id="course-left-sidebar" class="col-md-3">
                <div class="course-image-widget profile-img">
                    <img class="" src="{{ asset('images/' . $profile['image']) }}" alt=""
                        id="profile-image" class="img-responsive">
                </div>
            </div>

            <div class="col-md-9">
                <h3 calss="full-name">{{$profile['fname']}} {{$profile['lname']}}</h3>
                <div>
                    <div class="bio">
                        <div class="bio-info">
                            {{$profile['bio']}}
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                  
        <div class="col-md-12">
            <div class="tabbed-widget">
                <ul class="nav nav-tabs nav-rtl">
                    <li><a data-toggle="tab" href="#home">{{__('Single sessions')}}</a></li>
                    <li><a data-toggle="tab" href="#menu1">{{__('My courses')}}</a></li>

                </ul>
                <div class="clearfix"></div>
                <div class="tab-content">

                    <div id="home" class="tab-pane fade in active" style="overflow: hidden">
                        
                        
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="row">
                            <div class="instructor-courses">
                                @foreach($courses as $course)
                                    <div class="col-md-3 course-info">
                                        <div class="course-img">
                                            <img height="" src="{{ asset('images/' . $course->image) }}">
                                         </div>
                                        <div class="course-title">
                                            <a href="{{ route('courses.show', [$course->id])}}">{{$course->title}}</a>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                        <div class="row">
                                {{ $courses->links()}}
                                </div>
                    </div>
                   
                </div>
            </div>
        </div>
        </div>
       
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('front-assets/js/instructor.js') }}"></script>
@endsection