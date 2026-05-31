<!-- Modal for add lecture-->
<div class="modal fade" id="addlecture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title store-lecture" id="exampleModalLabel">{{__('Add New video')}}</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control lesson-name" name="name" value="" id="lesson-name"  placeholder="Enter lesson name ">
                  <input type="hidden" class="course_id" id="course_id" value="{{ $course->id }}">
                  <input type="hidden" class="section_id" id="section_id" value="">

                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                  <input type="radio"  name="url-type" id="computer-url" class="form-check-input" checked>
                  <label for="computer-url" class=" col-form-label">{{__('From computer')}}</label>
                </div>
              <div class="col-sm-6">
                <input type="radio"  name="url-type" id="external-url" class="form-check-input">
                <label for="external-url" class=" col-form-label">{{__('From url')}}</label>
              </div>
            </div>
            <div class="form-group row video-path computer-url">
              <label for="customFile" class="col-sm-2 col-form-label">{{__('video')}}</label>

              <div class="col-sm-10">
                <input type="file" class="custom-file-input form-control video" name="video" id="customFile">
                <input type="hidden" name="video64" id="video64" value="">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                  aria-valuemin="0" aria-valuemax="100" style="width:0%; margin-top:7px;">
                  0%
                </div>
              </div>
              
            </div>
            <div class="form-group row video-path external-url" style="display:none">
                <label for="url" class="col-sm-2 col-form-label">{{__('Url')}}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="external-url" id="url" placeholder="Enter external url">
                </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="description" value="" name="description" rows="2"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="duration" class="col-sm-2 col-form-label">{{__('Duration')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="duration" placeholder="Enter the duration like format h:m">
              </div>
            </div>
            <div class="form-group row">
              <label for="attachement" class="col-sm-2 col-form-label">{{__('Attachement')}}</label>

              <div class="col-sm-10">
                <input type="file" class="custom-file-input form-control attachement" name="attachement" id="attachement">
                <input type="hidden" name="pdf64" id="pdf64" value="">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <a data-url="{{ route('admin.lessones.video.store')}}" class="btn btn-primary store-video-lesson"> {{__('Save')}} </a>
        </div>
    
      </div>
    </div>
  </div>
