@extends('layouts.admin')
@section('title', __('Show Course'))
@section('content')
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="">
            <h2>{{ $course->title }}</h2>
        </div>
    </div>
</div>
<div class="row mt-4 justify-content-md-center">
    <div class="col-lg-6">
        <div class="c-content">
            <div class="section-container">
                @foreach($course->sections as $section)
                <section class="section">
                    <div class="action-section">
                    <a href="#" data-toggle="modal" data-target="#addsection" data-sectionId="{{$section->id}}" id="{{$course->id}}" data-name="{{$section->name}}" 
                    class="edit-section"><i class="far fa-edit"></i></a>
                    <a href="#" id="{{$section->id}}" data-url="{{ route('admin.sections.delete', [$section->id])}}" 
                      class="delete-section"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="section-title">
                        <h4> {{$section->name}} </h4>
                    </div>
                    <div class="all-lectures-{{$section->id}}">
                    @if($section->lessones)
                    @foreach($section->lessones as $lesson)
                    <div class="lecture" id="{{$lesson->id}}">
                        <div class="lecture-title-{{$lesson->id}}">
                            {{$lesson->name}}
                            <div class="action-lecture">
                            
                              <a href="#" data-toggle="modal" data-target="@if ($lesson->lessonable_type == 'App\Models\Video')#addlecture @else #addpdf @endif" data-sid="{{$section->id}}" 
                              data-lid="{{$lesson->id}}" data-name="{{$lesson->name}}" 
                                class="edit-lecture-modal"><i class="far fa-edit"></i></a>
                    
                              <a href="#" id="{{$lesson->id}}" 
                              data-url=" @if ($lesson->lessonable_type == 'App\Models\Video') {{ route('admin.lessones.video.delete', [$lesson->id])}} @else 
                              {{ route('admin.lessones.pdf.delete', [$lesson->id])}} @endif" 
                              class="delete-lecture"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                        <div class="lecture-resourse-{{$lesson->id}} lecture-items mt-3">
                            <div class="video-{{$lesson->id}} float-left float-left-rtl">
                                
                              <a href="#"> {{$lesson->lessonable->path}} </a>
                                 
                            </div>
                            
                        </div>
                    </div>
                    @endforeach
                    @endif
                    </div>
                    <div class="add-lecture">
                        <a href="#" data-toggle="modal" data-target="#addlecture" data-sid="{{$section->id}}" 
                        class="add-lecture-modal"><i class="fas fa-plus"></i>{{__('Video')}} </a>

                        <a href="#" data-toggle="modal" data-target="#addpdf" data-sid="{{$section->id}}" 
                        class="add-pdf-modal"><i class="fas fa-plus"> </i>{{__('Pdf')}} </a>

                    </div>
                </section>
                @endforeach
             </div>
            
            <div class="add-section">
                <a href="#" id="{{ $course->id }}" data-toggle="modal" data-target="#addsection" class="add-section-modal">
                  <i class="fas fa-plus"></i> {{__('Add Section')}} </a>
            </div>
         
        </div>
    </div>
</div>

<!-- Modal for add section-->
<div class="modal fade" id="addsection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title save" id="exampleModalLabel">{{__('Add New Section')}} </h5>
          <h5 class="modal-title edit" id="exampleModalLabel" >{{__('Update Section')}} </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('Name')}} </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control section-name" name="name" value=""  placeholder="Enter section name ">
                  <input type="hidden" class="course_id" id="course_id" value="{{ $course->id }}">
                  <input type="hidden" class="section_id" id="section_id" value="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}} </button>
          <a data-url="{{ route('admin.sections.store')}}" class="btn btn-primary admin-add-section save"> {{__('Save')}} </a>
          <a data-url="{{ route('admin.sections.update')}}" class="btn btn-primary edit update-section">{{__('Update')}} </a>

        </div>
    
      </div>
    </div>
  </div>


  
<!-- Modal for add lecture-->
<div class="modal fade" id="addlecture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title store-lecture" id="exampleModalLabel">{{__('Add New Lecture')}}</h5>
          <h5 class="modal-title edit-lecture" id="exampleModalLabel">{{__('Update Lecture')}}</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control lecture-name" name="name" value=""  placeholder="Enter Lecture name ">
                  <input type="hidden" class="course_id" id="course_id" value="{{ $course->id }}">
                  <input type="hidden" class="section_id" id="section_id" value="">

                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('video')}}</label>

                <div class="col-sm-10">
                <input type="file" style="width: 300px" class="custom-file-input form-control video" name="video" id="customFile">
                <label style="width: 300px" class="custom-file-label form-control" for="customFile">{{__('Choose video')}}</label>
                </div>
                <input type="hidden" name="video64" id="video64" value="">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <a data-url="{{ route('admin.lessones.video.store')}}" class="btn btn-primary store-lecture"> {{__('Save')}} </a>
          <a data-url="{{ route('admin.lessones.video.update')}}" class="btn btn-primary edit-lecture">{{__('Update')}}</a>
        </div>
    
      </div>
    </div>
  </div>

  <!-- Modal for add pdf lecture-->
<div class="modal fade" id="addpdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title store-pdf-lecture" id="exampleModalLabel">{{__('Add New pdf Lecture')}}</h5>
          <h5 class="modal-title edit-pdf-lecture" id="exampleModalLabel">{{__('Update pdf Lecture')}}</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control pdf-lecture-name" name="name" value=""  placeholder="Enter pdf Lecture name ">
                  <input type="hidden" class="course_id" id="course_id" value="{{ $course->id }}">
                  <input type="hidden" class="section_id" id="section_id" value="">

                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('pdf')}}</label>

                <div class="col-sm-10">
                <input type="file" style="width: 300px" class="custom-file-input form-control pdf-file" name="pdf" id="customFile">
                <label style="width: 300px" class="custom-file-label form-control" for="customFile">{{__('Choose pdf file')}}</label>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <a data-url="{{ route('admin.lessones.pdf.store')}}" class="btn btn-primary store-pdf-lecture"> {{__('Save')}} </a>
          <a data-url="{{ route('admin.lessones.pdf.update')}}" class="btn btn-primary edit-pdf-lecture">{{__('Update')}}</a>
        </div>
    
      </div>
    </div>
  </div>


@endsection

@section('js')
<script src="{{ asset('js/course.js') }}"></script>
@endsection

