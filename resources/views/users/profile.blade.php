@extends('layouts.front')
@section('title', __('My Profile') )
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<section class="white section">
    <div class="container">
        <div class="row">
        <form id="profile_form" method="post" action="{{ route('profiles.update')}}" enctype="multipart/form-data" data-url="{{ route('profiles.update')}}">
            @csrf
            @method('put')
            <div id="course-left-sidebar" class="col-md-3">
                <div class="course-image-widget profile-img">
                    <img src="{{ asset('images/' . $profile['image']) }}" alt=""
                        id="profile-img" class="img-responsive">
                        <input type="hidden" id="img64" value="">
                </div>
                <div class="save-img">                             
                    <button class="btn btn-primary profile-imgg" data-id="{{$profile['user_id']}}" 
                    data-url="#"> {{__('Save')}} </button>
                </div>

                <div class="form-group">
                    <input type="file" name="image" class="btn btn-primary customFilee" style="width: 100%;">
                </div>
            </div>
            <div id="course-content" class="col-md-9">
                <div class="course-description">
                    <h3 class="course-title"> {{__('Edit Profile')}}</h3>

                    <div class="edit-profile">
                        
                            <div class="form-group">
                                <label> {{__('First Name')}}</label>
                                <input type="text" class="form-control" name="fname" value=" {{$profile['fname']}} "
                                    placeholder="Ahmed">
                            </div>
                            @error('fname')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="form-group">
                                <label>  {{__('Last Name')}}</label>
                                <input type="text" class="form-control" name="lname" value=" {{$profile['lname']}}"
                                    placeholder="FOX">
                                    @error('lname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__('Address')}}</label>
                                <input type="text" class="form-control" name="address" value=" {{$profile['address']}}"
                                    placeholder="St Naser 255">
                                    @error('adress')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__('Country')}}</label>
                                <input type="text" class="form-control" name="country" value=" {{$profile['country']}} "
                                    placeholder="Palestine">
                                    @error('country')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label>{{__('Your knowledge level')}}</label>
                                <input type="text" class="form-control" name="level" value=" {{$profile['level']}} "
                                    placeholder="Expert">
                                    @error('level')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__('Your teaching interests')}} </label>
                                <input type="text" class="form-control" name="interests" value=" {{$profile['interests']}} "
                                    placeholder="ex: web development">
                                    @error('interests')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label>{{__('Your Bio')}} </label>
                                <textarea type="text" name="bio" class="form-control"
                                    placeholder="Your Bio">{{$profile['bio']}}</textarea>
                                    @error('bio')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label> {{__('Choose website language')}} </label>
                                <select name="locale" class="form-control">
                                    <option value=""> {{__('Select')}} </option>
                                    <option value="en" @if($profile['locale'] == 'en') selected @endif>{{__('English')}}</option>
                                    <option value="ar" @if($profile['locale'] == 'ar') selected @endif>{{__('Arabic')}}</option>
                                </select>
                                @error('locale')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary update-proo" data-url="{{ route('profiles.update')}}"> {{__('Submit Changes')}} </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection