@extends('layouts.front')
@section('content')

<section class="grey page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Course List Page</h1>
            </div>
            <div class="col-md-6 text-right">
                <div class="bread">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Courses</a></li>
                        <li class="active">Course List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="white section">
      <div class="container">
        
        <div class="row course-list">
          <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="shop-item-list entry">
                <form action="{{ route('search.index') }}" method="get">
                    @csrf
              <div class="">
                <h4>Categories</h4>
                <div>
                @foreach($categories as $category)
                    <div>
                        <input type="checkbox"  class="category" name="category[]" value="{{$category->id}}" id="category"> 
                        <lable for="category"> {{$category->name}} </lable>
                    </div>
                @endforeach
                </div>
                <div>
                    <h4>Price</h4>
                    <input type="text" placeholder="min" name="min"  class="form-control">
                    <input type="text" placeholder="max" name="max"  class="form-control">
                </div>
                <button type="submit">Submit</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-10 col-md-10">
            @foreach($courses as $course)
            <div class="shop-list-desc">
                <div>
                    <img height="60" src="{{ asset('images/' . $course->image) }}">
                </div>
                <div class="course-info">
                <h4><a href="course-single.html">{{$course->title}}</a></h4>
              <div class="shopmeta">
                <div class="pull-left"><strong>Course Price:</strong> {{$course->price}} $ </div>
                <div> <strong>Category:</strong> {{$course->category->name}} </div>
                <div class="rating pull-right">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div>
              </div>
              <hr class="invis clearfix">
              <p>{!! $course->description !!}</p>
              <a href="course-single.html" class="btn btn-default">Visit course</a>
            </div>
                </div>
              
            @endforeach
          </div>
        </div>
        <hr class="invis">
        <div class="row">
          <div class="col-md-12">
            <nav class="text-center">
            @if($courses)
                {{ $courses->links() }}
            @endif
            </nav>
          </div>
        </div>
      </div>
    </section>

@endsection