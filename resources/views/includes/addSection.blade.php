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