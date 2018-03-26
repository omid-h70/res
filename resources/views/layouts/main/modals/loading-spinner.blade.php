@section('extra-stylesheets')
    @parent
@endsection

<div class="modal fade" id="loading-spinner" tabindex="-1" role="dialog" aria-labelledby="loading-spinner">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="loading-spinner-title">
                    Please Wait...
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div  class="col-md-2 col-centered">
                        @include('layouts.main.modals.msg-box',[
                            'user_role'    => 'super_user',
                        ])

                        <i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom"></i>
                        <span class="sr-only">Loading...</span>
                        
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
