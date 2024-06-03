@extends('layouts.front')
@section('content')

<section class="grey page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>{{$course->title}}</h1>
            </div>

        </div>
    </div>
</section>
<section class="white section">
    <div class="container">
        <div class="row">
            <div id="course-left-sidebar" class="col-md-4">
                <div class="course-image-widget">
                    <img src="{{ asset('images/' . $course->image) }} " alt="" class="img-responsive">
                </div>
                <div class="course-meta">
                    <p class="course-category rtl-inverse">
                        <span> {{__('Category :')}} &nbsp;</span> 
                        <a href="course-list.html"> {{$course->category->name}} </a>
                    </p>
                    <hr>
                    <div class="rating">
    
                        <p class="rtl-inverse"> <span> {{__('Reviews')}} : &nbsp;</span>
                            @for ($i = 0; $i < $rating; $i++) <i class="fa fa-star"></i>
                                @endfor

                                <a title="" href="#reviews">&nbsp; ( {{$rating}} )</a></p>
                    </div>
                    <hr>
                    <p class="course-student rtl-inverse"><span> {{__('Students')}} : &nbsp;</span>
                       {{$courseUsers}} {{__('Members')}} </p>
                    <hr>
                    <p class="course-time rtl-inverse"><span> {{__('Length')}} :&nbsp;</span>
                         {{$lessonsCount}}
                         {{__('Lessons')}} </p>
                    <hr>
                    <p class="course-instructors rtl-inverse"><span> {{__('Instructor')}} :&nbsp;</span>
                        <a href="{{ route('instructor.profile.show', [$instructor->user_id]) }}"> {{ $instructor->fname .' '. $instructor->lname}} </a>
                    </p>
                    <hr>
                    <p class="course-price rtl-inverse"><span> {{__('Price')}} :&nbsp;</span>
                    <span class="coupon-price @if ($couponData['is_coupon_applied']) new-coupon-price @endif"> {{$course->price}} $</span>
                    <span>
                    @if ($couponData['is_coupon_applied']) {{$couponData['price']}} $ @endif
                    </span>
                    </p>
                    <hr>
                    @if(!$isUserEnrolled && $course->price != 0)
                    <div style="@if ($couponData['is_coupon_applied']) display:none @endif">
                     <a href="#" class="apply-coupon-btn">Apply coupon</a></div>
                    <div class="coupon" style="display:none">
                        <input type="text" class="coupon-code" placeholder="Enter your code" value="@if ($couponData['is_coupon_applied']) {{$couponData['code']}} @endif">
                        <a class="btn btn-primary coupon-apply" href="#" data-courseid="{{$course->id}}"
                            data-url="{{route('coupons.apply')}}" data-coursePrice="{{$course->price}}">Apply</a>
                            <p class="coupon-errors" style="display:none"></p>
                    </div>
                    
                    @endif
                    <div class="coupon-info" 
                    style="@if ($couponData['is_coupon_applied']) display:flex @else display:none @endif">
                        <p class="coupon-code">
                        @if ($couponData['is_coupon_applied']) {{$couponData['code']}} @endif
                        </p>
                        <a class="coupon-remove" data-url="{{route('coupons.delete')}}" href="#">Remove</a>
                    </div>
                </div>
                <div class="course-button" style="background-color: #5f687d">
                    @php $showButton = true; @endphp
                    @auth
                    @if($isUserEnrolled)
                    <a href="{{route('user.courses.show', [$course->id])}}" class="btn btn-primary btn-block"> {{__('Go To
                        Course')}} </a>
                    @php $showButton = false; @endphp
                    @endif
                    @endauth
                    @if ($showButton)
                    <!-- user not enroll in this course before -->
                    @if($course->price == 0)
                    <form action="{{route('course.enroll.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button type="submit" class="btn btn-primary btn-block"> {{__('Enroll')}} </button>
                    </form>
                    @elseif($isCourseInCart)
                    <a href="{{route('carts.index')}}" class="btn btn-primary btn-block"> {{__('Go To Cart')}} </a>
                    <form action="{{route('buy.store')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 2px"> {{__('Buy now')}} </button>
                    </form>
                    @else
                    <form action="{{route('carts.store')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block"> {{__('Add To Cart')}} </button>
                    </form>
                    <form action="{{route('buy.store')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 2px">{{__('Buy now')}}</button>
                    </form>

                    @endif
                    @endif
                </div>
            </div>
            <div id="course-content" class="col-md-8">
                <div class="course-description">
                    <div class="course-header">
                        <h3 class="course-title"> {{$course->title}} </h3>
                        <h4> {{ $course->sub_title }} </h4>

                        <small class="rtl-inline"><i> {{__('Last Updated')}} : </i><span> {{$course->updated_at}} </span> </small>
                        <small class="rtl-inline"><i> {{__('Language')}} : </i><span> {{$course->languge}} </span> </small>
                    </div>
                    <p class="more more-description">{!! $course->description !!}</p>
                </div>
                <div class="course-table">
                    <h4> {{__('Course Content')}} </h4>
                    <table class="table">
                        <tbody>
                            @foreach($course->sections as $section)

                            <tr class="c-section">
                                <td colspan="4">{{$section->name}}</td>
                            </tr>

                            @foreach($section->lessones as $lesson)
                            <tr>
                                <td><i class="fa fa-play-circle"></i></td>
                                <td><span>{{$lesson->name}}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <hr class="invis" style="border-color: #3f4451 ">

                <div class="other-courses">
                    <img src=" {{ asset('front-assets/images/xothers.png.pagespeed.ic.BLyi2PaMRC.png') }} " alt=""
                        class="">
                </div>
            </div>
        </div>
        <hr class="invis">
        <div id="owl-featured" class="owl-custom">
            @foreach ($featuredCourses as $course)
            <div class="owl-featured">
                <div class="shop-item-list entry">
                    <div class="">
                        <img src="{{ asset('images/' . $course->image) }}" alt="">
                        <div class="magnifier">
                        </div>
                    </div>
                    <div class="shop-item-title clearfix">
                        <h4><a href="{{ route('courses.show', [$course->id])}}">{{$course->title}}</a></h4>
                        <div class="shopmeta">
                            <span class="pull-left">{{$course->price ? $course->price . '$' : 'Free'}} </span>
                            <div class="rating pull-right">
                                
                                <p>
                                    @if (! $rating)
                                    <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                                    @else
                                    @for ($i = 0; $i < $rating; $i++)
                                     <i class="fa fa-star"></i>
                                    @endfor
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="visible-buttons">
                       
                        <a title="Read More" href="{{ route('courses.show', [$course->id])}}"><span
                                class="fa fa-search"></span></a>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>

@endsection
@section('js')
    <script src="{{ asset('front-assets/js/showCourse.js') }}"></script>
@endsection