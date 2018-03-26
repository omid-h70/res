<!-- Modal -->
<div class="modal fade" id="add-category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ trans('food.add_new_category') }}</h4>
      </div>
      <div class="modal-body">
            <div id="category-status-error" class="hidden row">       
                <div class="col-md-10 col-centered alert alert-danger alert-dismissible fade in" role=alert>
                    <p id="error">
                      <span class="close">
                          <i class="fa fa-remove fa-fw" class="close"></i>
                      </span>
                    </p>
                </div>
            </div>
            <div id="category-status-success" class="hidden row">  
                <div class="bg-success col-md-10 col-centered alert  alert-dismissible fade in" >	
                    <p class="" id="success">
                    <span class="close"><i class="fa fa-check fa-fw" class="close"></i>
                    </span>
                    </p>
                </div>
            </div>
            <div class="row">

                <div class="col-md-2">
                    <label for="exampleInputEmail1">{{ trans('food.add') }}</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="add-category" name="category_title" placeholder="{{ trans('food.category_title') }}">
                    </div>
                </div>

            </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('food.close') }} </button>
        <button id="save-category-btn" type="button" class="btn btn-primary">{{ trans('food.save') }} </button>
      </div>
    </div>
  </div>
</div>
<!-- End Of Modal -->