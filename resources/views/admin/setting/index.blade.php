@extends('layouts.admin.main') 

@section('linked-stylesheets')
    @parent
        @include('layouts.styles.bootflat')
@endsection

@section('sidebar')
    @include('layouts.admin.sidebar',['_global_sidebar_array'=>$_global_sidebar_array]) 
@endsection 

@section('content')
    
    <h2 class="example-title">{{ trans('setting.setting') }}</h2>
    <hr class="dashed" >
    
    <div class="row">
        <?php  Helper::showErrors( $errors ); ?>
    </div>
    <div class="row">
        @if( isset( $SuccessArray ))
            <?php  Helper::showSuccess( $SuccessArray ); ?>
        @endif
    </div>
    
    <form class="form-horizontal" role="form" method="POST" action="{{ url(App::getLocale().'/admin/setting/general') }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
        <div class="row">
            <div class="col-md-3"> 
               {{ trans('setting.site_title') }}
            </div> 
            <div class="col-md-3"> 
               <input type="text" class="form-control" name="site_title" placeholder="{{ trans('setting.title') }}" value="{{ !empty(old('site_title'))?old('site_title'):(!empty($site_title)?$site_title:$SITE_TITLE)  }}" style="">
            </div> 
        </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    {{ trans('setting.double_lang') }}  
                </div>
                <div class="col-md-3">
                    <label class="toggle">
                      <input type="checkbox" >
                      <span class="handle"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    {{ trans('setting.time_format') }}  
                </div>
                <div class="col-md-3">
                    <select name="category_select" form="add-food-form" class="form-control">
                        <option value="none"  > {{ trans('setting.shamsi_format') }}  </option>
                        <option value="">       {{ trans('setting.ad_format') }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    {{ trans('setting.membership') }}  
                </div>
                <div class="col-md-3">    
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            {{ trans('setting.free_register') }} 
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row" >
            <div class="col-sm-2">
               <button type="submit" value="submit" class="btn btn-success btn-block">{{ trans('setting.save') }}</button>
            </div> 
            <div class="col-sm-1">
            </div>
            <div class="col-sm-2 col-sm-offset-1">
               <button type="reset" value="reset" class="btn btn-danger btn-block">{{ trans('setting.reset') }}</button>
            </div> 
        </div>
    </form>    

@endsection