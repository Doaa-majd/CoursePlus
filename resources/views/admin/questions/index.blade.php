@extends('layouts.admin')
@section('title', __('Questions'))
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800">{{__('Questions')}}</h2>
  <div class="ml-auto">
  </div>
</div>

<table class="table mt-3">
  <tr>
    <th>{{__('No')}}</th>
    <th>{{__('Question')}}</th>
    <th>{{__('In coures')}}</th> 
    <th>{{__('Asked by')}}</th>
    <th>{{__('Created At')}}</th>
    <th>{{__('Actions')}}</th>
  </tr>
  @foreach($questions as $key => $question)
  <tr>
    <td>{{ ++$key }}</td>
    <td class="question-body-{{$question->id}}">{{$question->question}}</td>
    <td> <a href="{{route('courses.show', [$question->course->id])}}" class="">
      {{$question->course->title}}</a>
    </td>
    <td>{{$question->user->name}}</td>
    <td>{{$question->created_at->diffForHumans()}}</td>
    <td>
      <div class="d-flex">
      <a href="#" data-toggle="modal" data-target="#question" data-id="{{$question->id}}" data-question="{{$question->question}}" class="btn btn-outline-success mr-1 btn-sm edit-question">{{__('Edit')}}</a> 
      <a href="#" data-url="{{ route('admin.questions.delete', [$question->id])}}"  class="btn btn-outline-danger btn-sm delete-question">{{__('Delete')}}</a> 
  
      </div>
    </td>
  </tr>
  @endforeach

</table>

<div class="modal fade" id="question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title edit" id="exampleModalLabel" >{{__('Edit question')}}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
          <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">{{__('Question')}}</label>
              <div class="col-sm-10">
                <textarea class="form-control question-text" id="question" value="" name="question" rows="2"> </textarea>
                <input type="hidden" class="question_id" id="question_id" value="">
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <a data-url="{{ route('admin.questions.update')}}" class="btn btn-primary update-question">{{__('Update')}}</a>

      </div>
  
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/question.js') }}"></script>
@endsection