@extends('layouts.front')
@section('content')


<div class="container">
    <div class="row">
            <div class="edit-profile">
                <div class="instuctor-profile">
                    <h2> {{__('Instructor information')}} </h2>
                    <form role="form" action="{{ route('instructors.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label> {{__('First Name')}} <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" placeholder="Ahmed">
                                @error('fname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>  {{__('Last Name')}} <span style="color:red">*</span> </label>
                            <input type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" placeholder="Fox">
                                @error('lname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label> {{__('Country')}} <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" placeholder="">
                                @error('country')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>{{__('Adress')}}</label>
                            <input type="text" class="form-control @error('adress') is-invalid @enderror" name="adress" value="{{ old('adress') }}" placeholder="adress">
                                @error('adress')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>{{__('Mobile number')}}</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" placeholder="mobile number">
                                @error('mobile')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>{{__('Your Bio')}} <span style="color:red">*</span></label>
                            <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" cols="50"></textarea>  
                            @error('bio')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                      </div>

                        <button type="submit" class="btn btn-primary"> {{__('Submit')}} </button>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection