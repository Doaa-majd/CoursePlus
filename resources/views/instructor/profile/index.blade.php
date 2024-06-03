@extends('layouts.front')
@section('title', __('My Profile') )
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<section class="white profile-section">
    <div class="container">
        <div class="row">
            <div class="cover-img">
                <img class="" src="{{ asset('images/' . $profile['cover_image']) }}" alt="" id="cover-image" class="">
                <div class="cover-image-edit">
                    <div class="edit-icon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="hidden" id="coverImg64" value="">
                    <div class="form-group">
                        <input type="file" name="image" class="btn btn-primary customFile cover-image" data-url="{{ route('instructor.profile.update') }}">
                    </div>
                </div>
                @if ($profile['cover_image'])
                <div class="cover-image-delete" data-url="{{ route('instructor.profile.delete') }}">
                    <i class="fa fa-trash"></i>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div id="course-left-sidebar" class="col-md-3">
                <div class="course-image-widget profile-img">
                <img class="" src="{{ asset('images/' . $profile['image']) }}" alt=""
                        id="profile-image" class="img-responsive">
                <div class="edit-icon">
                    <i class="fa fa-pencil"></i>
                </div>
                <input type="hidden" id="img64" value="">
                </div>
                <div class="form-group">
                    <input type="file" name="image" class="btn btn-primary customFile instructor-image" data-url="{{ route('instructor.profile.update') }}">
                </div>
                @if ($profile['image'])
                <div class="image-delete" data-url="{{ route('instructor.profile.delete') }}">
                    <i class="fa fa-trash"></i>
                </div>
                @endif
            </div>

            <div class="col-md-9">
                <h3 calss="full-name">{{$profile['fname']}} {{$profile['lname']}}</h3>
                <div class="instructor-name">
                    <label for="fname">{{__('First name')}}</label>
                    <input type="text" id="fname" class="fname" value="{{$profile['fname']}}">
                    <label for="fname">{{__('Last name')}}</label>
                    <input type="text" id="lname" class="lname" value="{{$profile['lname']}}">
                </div>
                <div>
                    <div class="bio">
                        <div class="bio-info">
                            {{$profile['bio']}}
                        </div>      
                        <div class="bio-textarea-div">
                            <textarea name="bio" class="bio-textarea" id="">{{$profile['bio']}}</textarea>
                            <a href="#" class="btn btn-primary save-bio" data-url="{{ route('instructor.profile.update') }}">save</a>
                        </div>
                    </div>
                    <div class="bio-edit">
                        <div class="edit-icon gray-icon edit-icon-bio">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                  
        <div class="col-md-12">
            <div class="tabbed-widget">
                <ul class="nav nav-tabs nav-rtl">
                    <li class="active"><a data-toggle="tab" href="#home"> {{__('Personal information')}} </a></li>
                    <li><a data-toggle="tab" href="#menu1">{{__('Single sessions')}}</a></li>
                    <li><a data-toggle="tab" href="#menu2">{{__('My courses')}}</a></li>

                </ul>
                <div class="clearfix"></div>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active" style="overflow: hidden">
                        <div class="description-div">
                            <div class="d-flex description-item">
                                <label>{{__('Country')}}:</label>
                                <div class="space"></div>
                                <span class="country-span">{{$profile['country']}}</span>
                            </div>
                            <div  class="d-flex description-item">
                                <label>{{__('Adress')}}:</label>
                                <div class="space"></div>
                                <span class="address-span">{{$profile['address']}}</span>
                            </div>
                            <div  class="d-flex description-item">
                                <label>{{__('Mobile')}}:</label>
                                <div class="space"></div>
                                <span class="mobile-span">{{$profile['mobile']}}</span>
                            </div>
                            <a href="#" class="btn btn-primary edit-btn">Edit</a>
                        </div>
                        <div class="description-div-edit">
                            <div class="d-flex description-item">
                                <label>{{__('Country')}}:</label>
                                <div class="space"></div>
                                <input type="text" id="country" class="country" value="{{$profile['country']}}">
                            </div>
                            <div  class="d-flex description-item">
                                <label>{{__('Address')}}:</label>
                                <div class="space"></div>
                                <input type="text" id="address" class="address" value="{{$profile['address']}}">
                            </div>
                            <div  class="d-flex description-item">
                                <label>{{__('Mobile')}}:</label>
                                <div class="space"></div>
                                <input type="text" id="mobile" class="mobile" value="{{$profile['mobile']}}">
                            </div>
                            <a href="#" class="btn btn-primary save-btn" data-url="{{ route('instructor.profile.update') }}">Save</a>
                        </div>

                    </div>

                    <div id="menu1" class="tab-pane fade">
                        
                        
                    </div>
                    <div id="menu2" class="tab-pane fade">
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