<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    <div class="title">{{Voyager::setting('admin.title', 'VOYAGER')}}</div>
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/bg.jpg') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ $user_avatar }}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>

                    <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>
        <div id="adminmenu">
            <ul class="nav navbar-nav">
                @php
                    $menuItems = json_decode(menu('admin', '_json'));
                    $currentUrl = url()->current();
                    
                    function isActive($item, $currentUrl) {
                        if ($item->href == $currentUrl && $item->href != '') {
                            return true;
                        }
                        if (str_starts_with($currentUrl, rtrim($item->href, '/') . '/')) {
                            return true;
                        }
                        if (($item->href == url('') || $item->href == route('voyager.dashboard')) && !empty($item->children)) {
                            return false;
                        }
                        if ($item->href == route('voyager.dashboard') && $currentUrl != route('voyager.dashboard')) {
                            return false;
                        }
                        if (!empty($item->children)) {
                            foreach ($item->children as $child) {
                                if (isActive($child, $currentUrl)) {
                                    return true;
                                }
                            }
                        }
                        return false;
                    }
                @endphp
                @foreach($menuItems as $item)
                    @php
                        $isItemActive = isActive($item, $currentUrl);
                    @endphp
                    <li class="@if(!empty($item->children)) dropdown @endif @if($isItemActive) active @endif">
                        <a target="{{ $item->target }}" href="{{ !empty($item->children) ? '#'.$item->id.'-dropdown-element' : $item->href }}" 
                           style="{{ !empty($item->color) && $item->color != '#000000' ? 'color:'.$item->color : '' }}"
                           @if(!empty($item->children)) data-toggle="collapse" aria-expanded="{{ $isItemActive ? 'true' : 'false' }}" @endif>
                            <span class="icon {{ $item->icon_class }}"></span>
                            <span class="title">{{ $item->title }}</span>
                        </a>
                        @if(!empty($item->children))
                            <div id="{{ $item->id }}-dropdown-element" class="panel-collapse collapse {{ $isItemActive ? 'in' : '' }}">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        @foreach($item->children as $child)
                                            @php
                                                $isChildActive = isActive($child, $currentUrl);
                                            @endphp
                                            <li class="{{ $isChildActive ? 'active' : '' }}">
                                                <a target="{{ $child->target }}" href="{{ $child->href }}"
                                                   style="{{ !empty($child->color) && $child->color != '#000000' ? 'color:'.$child->color : '' }}">
                                                    <span class="icon {{ $child->icon_class }}"></span>
                                                    <span class="title">{{ $child->title }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>
