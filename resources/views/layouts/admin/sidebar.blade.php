<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ url(App::getLocale().'/admin' ) }}">
                    <i class="fa fa-dashboard fa-lg fa-fw"></i> 
                    {{ trans('admin.dashboard') }}
                </a>
            </li>
            @if( !empty($_global_sidebar_array) )
                @foreach( $_global_sidebar_array['urls'] as $parent_url ) 
                    @if( Helper::userHasPermission(Helper::getPermissionSlug($parent_url['url_namespace'],$parent_url['url_controller'])) )
                    <li>
                        <a href="{{ url(App::getLocale().'/'.$parent_url['url_namespace'].'/'.$parent_url['url_controller']) }}">
                            <i class="fa {{$parent_url['url_icon_class'] }} fa-lg fa-fw"></i> 
                            {{ trans( $parent_url['url_title']) }}
                            @if( !empty($parent_url['children']) ) 
                                <span class="fa arrow"></span>
                            @endif
                        </a>
                        @if( !empty($parent_url['children']) )
                            <ul class="nav nav-second-level">
                                @foreach( $parent_url['children'] as $child_url)
                                    @if( Helper::userHasPermission(Helper::getPermissionSlug($parent_url['url_namespace'],$parent_url['url_controller'],$child_url['url_slug'])) )
                                        <li>
                                            <a href="{{ url(App::getLocale().'/'.$parent_url['url_namespace'].'/'.$parent_url['url_controller'].'/'.$child_url['url_slug']) }}">
                                                <i class="fa {{ $child_url['url_icon_class'] }} fa-fw" style="color:purple;"></i>
                                                {{ trans( $child_url['url_title']) }}
                                            </a>
                                        </li>  
                                    @endif
                                @endforeach
                            </ul> <!-- /.nav-second-level -->
                        @endif
                    </li>
                    @endif
                @endforeach
            @endif
        </ul> <!-- / side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
