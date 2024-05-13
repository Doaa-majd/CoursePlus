@extends('layouts.admin')
@section('title', __('Add Questions'))
@section('content')
<h3> {{$course->title}} </h3>
<h6> {{__('Section')}}: {{$section->name}} </h6>

<h6> {{__('Add questions to exam ')}}: {{$lecture->name}} </h6>

<a href="#" class="btn btn-outline-info btn-sm add-question">{{__('Add Question')}}</a>
<div class="add-question-area" style="display: none">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="question">{{__('Question')}}</label>
                <input type="text" class="form-control" name="question" value="" id="question"
                    placeholder="Enter your question">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-1">
            <div class="form-group">      
                <label for="answer1">{{__('Answer 1')}}</label>
                <input type="text" class="form-control" name="answer1" value="" id="answer1" placeholder="">
            </div>
            
        </div>
        <div class="col-lg-3 col-md-4 col-sm-1">
            <div class="form-group">
                <label for="answer2">{{__('Answer 2')}}</label>
                <input type="text" class="form-control" name="answer2" value="" id="answer2" placeholder="">
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-1">
            <div class="form-group">
                <label for="answer3">{{__('Answer 3')}}</label>
                <input type="text" class="form-control" name="answer3" value="" id="answer3" placeholder="">
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-1">
            <div class="form-group">
                <label for="answer4">{{__('Answer 4')}}</label>
                <input type="text" class="form-control" name="answer4" value="" id="answer4" placeholder="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
        <label for="true_answer">{{__('True answer')}}</label>
        <select name="true_answer" id="answer-option" class="custom-select answer">
            <option value=""> -- </option>
              <option value="1">{{__('Answer 1')}}</option> 
              <option value="2">{{__('Answer 2')}}</option>    
              <option value="3">{{__('Answer 3')}}</option>    
              <option value="4">{{__('Answer 4')}}</option>       
          </select> 
        </div>
    </div>
    <input type="hidden" class="question-id" name="id" value="">
    <a href="#" data-url="{{ route('admin.exam.add')}}" data-id="{{$lecture->id}}" class="btn btn-info btn-sm save-question">{{__('Save')}}</a>
    <a href="#" style="display: hidden" data-url="{{ route('admin.exam.updateQ')}}" data-id="{{$lecture->id}}" class="btn btn-info btn-sm update-question">{{__('Update')}}</a>

</div>
<table class="table mt-3">
    <th style="width: 300px;"> {{__('Question')}} </th>
    <th> {{__('Answer 1')}} </th>
    <th> {{__('Answer 2')}} </th>
    <th> {{__('Answer 3')}} </th>
    <th> {{__('Answer 4')}} </th>
    <th style="width: 50px;"> {{__('Actions')}} </th>

    @foreach($questions as $key => $question)
    <tr> 
        <td class="q-{{$question->id}}">{{$question->equestion}} </td>
        <td id="{{$question->answer}}" class="@if($question->answer == 1)true-answer @endif c1-{{$question->id}}">{{$question->choice1}} </td>
        <td id="{{$question->answer}}" class="@if($question->answer == 2)true-answer @endif c2-{{$question->id}}">{{$question->choice2}} </td>
        <td id="{{$question->answer}}" class="@if($question->answer == 3)true-answer @endif c3-{{$question->id}}">{{$question->choice3}} </td>
        <td id="{{$question->answer}}" class="@if($question->answer == 4)true-answer @endif c4-{{$question->id}}">{{$question->choice4}} </td>
        <td>
            <div class="d-flex">
                <a href="#" id="{{$question->id}}" class="btn btn-outline-success mr-1 btn-sm edit-question"> {{__('Edit')}} </a> 
                <a href="#" data-url="{{ route('admin.exam.delete', [$question->id])}}"  class="btn btn-outline-danger btn-sm delete-question">{{__('Delete')}} </a> 
            </div> 
        </td>
    </tr>
    @endforeach
</table>

@endsection

@section('js')
<script src="{{ asset('js/exam.js') }}"></script>

@endsection

