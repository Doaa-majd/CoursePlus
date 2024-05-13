@extends('layouts.front')
@section('content')


<section class="slider-section">
    <div class="tp-banner-container">
      <div class="tp-banner">
        <ul>
         
          <li data-transition="fade" data-slotamount="1" data-masterspeed="500" data-thumb="{{ asset('front-assets/upload/slider_new_02.jpg') }}"
            data-saveperformance="off" data-title="Slide">
            <img src="{{ asset('images/' . $settings['Slider 1'] ) }}" alt="fullslide1"
              data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
              <div class="tp-caption slider_layer_01 text-center lft tp-resizeme" data-x="center" data-y="220"
              data-speed="1000" data-start="600" data-easing="Power3.easeInOut" data-splitin="none"
              data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000"
              style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;"><i
                class="fa fa-graduation-cap"></i> {{ $settings['Slider title'] }}
            </div>
            <div class="tp-caption slider_layer_02 text-center lft tp-resizeme" data-x="center" data-y="320"
              data-speed="1000" data-start="800" data-easing="Power3.easeInOut" data-splitin="none"
              data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000"
              style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;"> 
              {{ $settings['Slider Description'] }}

            </div>
          
          </li>
          <li data-transition="fade" data-slotamount="1" data-masterspeed="500" data-thumb="{{ asset('front-assets/upload/slider_new_01.jpg') }}"
            data-saveperformance="off" data-title="Slide">
            <img src="{{ asset('images/' . $settings['Slider 2'] ) }}" alt="fullslide1"
              data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
            <div class="tp-caption slider_layer_01 text-center lft tp-resizeme" data-x="center" data-y="220"
              data-speed="1000" data-start="600" data-easing="Power3.easeInOut" data-splitin="none"
              data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000"
              style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;"><i
                class="fa fa-graduation-cap"></i> {{ $settings['Slider title'] }}
            </div>
            <div class="tp-caption slider_layer_02 text-center lft tp-resizeme" data-x="center" data-y="320"
              data-speed="1000" data-start="800" data-easing="Power3.easeInOut" data-splitin="none"
              data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000"
              style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
              {{ $settings['Slider Description'] }}
            </div>
            
          </li>      
         
        </ul>
      </div>
    </div>
</section>
  
  <section class="grey section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-title text-center">
            <h4>{{__('Popular Courses')}}</h4>
            <p> {{$settings['Courses description']}} </p>
          </div>
        </div>
      </div>
      <div id="owl-featured" class="owl-custom">
        @foreach($courses as $course)
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
                     
                </div>
              </div>
            </div>
            <div class="visible-buttons">
              <a title="Read More" href="{{ route('courses.show', [$course->id])}}"><span class="fa fa-search"></span></a>
            </div>
          </div>
        </div>
        @endforeach
       
      </div>
    </div>
  </section>
 
  <section class="section fullscreen paralbackground parallax"
    style="background-image:url(upload/xparallax_02.jpg.pagespeed.ic.Sx1_qXOliB.jpg)" data-img-width="1627"
    data-img-height="868" data-diff="100">
    <div class="overlay green-overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-title text-center">
            <h4>{{ __('Happy Milistones')}}</h4>
            <p> {{$settings['Milistones']}}</p>
          </div>
        </div>
      </div>
      <div class="row service-center funfactors">
        <div class="col-md-4 col-sm-6">
          <div class="feature-list">
            <i class="stat-count">{{$settings['Milistone 1#num']}} </i>
            <p><strong>{{$settings['Milistone one title']}}</strong></p>
            <p>{{$settings['Milistone one description']}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="feature-list">
            <i class="stat-count"> {{$settings['Milistone 2#num']}}</i>
            <p><strong>{{$settings['Milistone two title']}}</strong></p>
            <p>{{$settings['Milistone two description']}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="feature-list">
            <i class="stat-count">{{$settings['Milistone 3#num']}}</i>
            <p><strong> {{$settings['Milistone three title']}} </strong></p>
            <p>{{$settings['Milistone three description']}}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="white section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-title text-center">
            <h4>{{__('Our Clients')}}</h4>
            <p>{{$settings['Our Clients']}}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_01.png.pagespeed.ic.m5NnlxSzhM.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_02.png.pagespeed.ic.BsH9V4BqCi.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_03.png.pagespeed.ic.mxzQrepbL_.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_04.png.pagespeed.ic.Fx2ObIy0Eb.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_05.png.pagespeed.ic.GBNy2ra72B.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-md-2">
          <img src="{{ asset('front-assets/upload/xclient_06.png.pagespeed.ic.a_uqmnbFy0.png') }}" alt="" class="img-responsive img-thumbnail">
        </div>
      </div>
    </div>
  </section>

@endsection