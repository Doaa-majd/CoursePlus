@extends('layouts.admin')
@section('title', __('Edit Category') )
@section('content')
<h2 class="text-center"> {{__('Edit Category')}} </h2>
<div class="mx-auto mt-5 mx-rtl" style="width: 500px;">
<form action="{{ route('admin.categories.update', [$category->id])}}" method="post">
    @csrf
    @method('put')
    <div class="form-group">
        <label for="name">{{__('Category Name')}}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$category->name) }}" id="name" placeholder="Enter Name Here">
        @error('name')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

<div class="form-group">
    <select id="parent-cat" name="parent_id" class="custom-select @error('parent_id') is-invalid @enderror">
        <option value="">{{__('No Parent')}}</option>
        @foreach(App\Models\Category::all() as $cat)
        <option @if ($cat->id == old('parent_id') || $cat->id == $category->parent_id) selected @endif value="{{$cat->id}}">{{$cat->name}}</option>
        @endforeach
      </select> 
      @error('parent_id')
          <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="published" value="published" @if ($category->status == 'published') checked @endif>
        <label class="form-check-label" for="published">
          {{__('Published')}}
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="draft" value="draft" @if ($category->status == 'draft') checked @endif>
        <label class="form-check-label" for="draft">
          {{__('Draft')}} 
        </label>
      </div>
      @error('status')
          <p class="text-danger">{{ $message }}</p>
        @enderror

    <button type="submit" class="btn btn-primary mt-4">{{__('Edit')}}</button>
  </form> 
</div>
@endsection
