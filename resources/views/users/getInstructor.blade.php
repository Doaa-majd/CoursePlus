@extends('layouts.front')
@section('title', __('My Profile') )
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<section class="slider-section">
<div class="tp-banner-container">
<div class="tp-banner">
<ul>
<li data-transition="fade" data-slotamount="1" data-masterspeed="500" data-thumb="upload/slider_new_01.jpg" data-saveperformance="off" data-title="Slide">
<img src="{{ asset('front-assets/images/slider.jpg') }}" alt="fullslide1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
<div class="tp-caption slider_layer_01 text-center lft tp-resizeme" data-x="center" data-y="220" data-speed="1000" data-start="600" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000" style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;"><i class="fa fa-graduation-cap"></i> Learn<strong>PLUS</strong>
</div>
<div class="tp-caption slider_layer_02 text-center lft tp-resizeme" data-x="center" data-y="320" data-speed="1000" data-start="800" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000" style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">Great Theme For Education, University Learning Websites<br> with tons of options and custom sections!
</div>
<div class="tp-caption text-center lft tp-resizeme" data-x="center" data-y="390" data-speed="1000" data-start="800" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="1000" style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;"><a href="{{ route('instructors.create') }}" class="btn btn-default">Become an instructor</a>
</div>
</li>
</ul>
</div>
</div>
</section>

<section class="white section">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="section-title text-center">
<h4>Our Features</h4>
<p>Simply The Most Featured Rich HTML5 Learning Management System</p>
</div>
</div>
</div>
<div class="row service-center">
<div class="col-md-4 col-sm-6">
<div class="feature-list border-radius">
<i class="fa fa-graduation-cap"></i>
<p><strong>Multi-Tier Courses</strong></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiing elit. Integer loectetur adipiing elit. Integer lectetur adipiing elit. Integer lrem quam..</p>
</div>
</div>
<div class="col-md-4 col-sm-6">
<div class="feature-list border-radius">
<i class="fa fa-shopping-cart"></i>
<p><strong>Sell Online Courses</strong></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiing elit. Integer loectetur adipiing elit. Integer lectetur adipiing elit. Integer lrem quam..</p>
</div>
</div>
<div class="col-md-4 col-sm-6">
<div class="feature-list border-radius">
<i class="fa fa-question"></i>
<p><strong>Advanced Quizzing</strong></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiing elit. Integer loectetur adipiing elit. Integer lectetur adipiing elit. Integer lrem quam..</p>
</div>
</div>
</div>
<hr class="invis">
<div class="callout row">
<div class="col-md-8">
<h4><i class="fa fa-graduation-cap fa-3x alignleft"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">Vestibulum non</a><br> dolor ultricies, porttitor justo non.</h4>
</div>
<div class="col-md-4">
<a href="{{ route('instructors.create') }}" class="btn btn-primary btn-block">Become an instructor</a>
</div>
</div>
</div>
</section>

@endsection