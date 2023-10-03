<div class="k-aside-menu-wrapper k-grid__item k-grid__item--fluid" id="k_aside_menu_wrapper">
	<div id="k_aside_menu" class="k-aside-menu " data-kmenu-vertical="1" data-kmenu-scroll="1" data-kmenu-dropdown-timeout="500">
        <ul class="k-menu__nav">
            @foreach($LEFT_MENU as $menu)
                @php
                    $hasPermission = !empty(data_get($menu, 'permissions')) ? $AUTHENTICATED_ADMIN->canAny(data_get($menu, 'permissions')) : true;
                    $hasSubMenu = !empty(data_get($menu, 'subs'));
                @endphp

                @if($hasPermission)
                <li class="k-menu__item {{ $hasSubMenu ? 'k-menu__item--submenu' : '' }}" {{ $hasSubMenu ? 'aria-haspopup="true" data-kmenu-submenu-toggle="hover"' : '' }}>
                    <a href="{{ data_get($menu, 'link', 'javascript:;') }}" class="k-menu__link {{ $hasSubMenu ? 'k-menu__toggle' : '' }}">
                        <i class="k-menu__link-icon {{ data_get($menu, 'icon') }}"></i>
                        <span class="k-menu__link-text">{{ __(data_get($menu, 'name')) }}</span>
                        @if($hasSubMenu)
                        <i class="k-menu__ver-arrow la la-angle-right"></i>
                        @endif
                    </a>

                    @if($hasSubMenu)
                    <div class="k-menu__submenu ">
                        <span class="k-menu__arrow"></span>
                        <ul class="k-menu__subnav">
                        @foreach(data_get($menu, 'subs', []) as $menu)
                            @php
                                $hasPermission = !empty(data_get($menu, 'permissions')) ? $AUTHENTICATED_ADMIN->canAny(data_get($menu, 'permissions')) : true;
                                $hasSubMenu = !empty(data_get($menu, 'subs'));
                            @endphp

                            @if($hasPermission)
                            @php
                                $subtextResponseField = data_get($menu, 'subtext-response-field', '');
                                $id = data_get($menu, 'id', '');
                                $subtextAjaxUrl = data_get($menu, 'subtext_ajax_url', '');
                                $hasSubMenuClass = $hasSubMenu ? 'k-menu__item--submenu' : '';
                                $hasSubMenuAttributes = $hasSubMenu ? 'aria-haspopup="true" data-kmenu-submenu-toggle="hover"' : '';
                            @endphp
                            <li
                                class="k-menu__item {{ $hasSubMenuClass }}"
                                {{ $subtextResponseField ? "data-subtext-response-field={$subtextResponseField}" : '' }}
                                {{ $id ? "id={$id}" : '' }}
                                {{ $subtextAjaxUrl ? "data-get-url={$subtextAjaxUrl}" : '' }}
                                {{ $hasSubMenuAttributes }}
                            >

                            <a href="{{data_get($menu, 'link', 'javascript:;') }}" class="k-menu__link {{ $hasSubMenu ? 'k-menu__toggle' : '' }}">
                                <i class="k-menu__link-bullet k-menu__link-bullet--dot"><span></span></i>
                                <span class="k-menu__link-text">{{ __(data_get($menu, 'name')) }}</span>
                                @if (data_get($menu, 'subtext'))
                                <span class="k-menu__link-badge">
                                    <span class="badge badge-pill badge-primary">{{ data_get($menu, 'subtext') }}</span>
                                </span>
                                @endif

                                @if (data_get($menu, 'subtexts'))
                                    @foreach(data_get($menu, 'subtexts', []) as $item)
                                    <span data-get-url="{{ data_get($item, 'ajax_url') }}" data-subtext-response-field="{{ data_get($item, 'response_field') }}" class="k-menu__link-badge">
                                        <span  id="{{ data_get($menu, 'id') }}_pill_{{ $loop->index }}" class="badge badge-pill badge-{{ data_get($item, 'class') }}">{{ data_get($item, 'value') }}</span>
                                    </span>
                                    @endforeach
                                @endif
                                @if($hasSubMenu)
                                <i class="k-menu__ver-arrow la la-angle-right"></i>
                                @endif
                            </a>
                            @if($hasSubMenu)
                            <div class="k-menu__submenu "><span class="k-menu__arrow"></span>
                                <ul class="k-menu__subnav">
                                    @foreach(data_get($menu, 'subs', []) as $menu)
                                    @php
                                        $hasPermission = !empty(data_get($menu, 'permissions')) ? $AUTHENTICATED_ADMIN->canAny(data_get($menu, 'permissions')) : true;
                                        $hasSubMenu = !empty(data_get($menu, 'subs'));
                                    @endphp
                                    @if($hasPermission)
                                    <li class="k-menu__item">
                                        <a href="{{$menu['link'] ?? 'javascript:;'}}" class="k-menu__link">
                                            <i class="k-menu__link-bullet k-menu__link-bullet--dot"><span></span></i>
                                            <span class="k-menu__link-text">{{ __(data_get($menu, 'name')) }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                    @endif
                </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

@push('js_pages')
<script>
    const MENU_CONFIG = {
        init: () => {
            MENU_CONFIG.removeEmptySubMenu();
            MENU_CONFIG.activeMenuByUrl();
            MENU_CONFIG.renderCountingMenuItemSubtext();
        },
        removeEmptySubMenu: () => {
            $.each($('#k_aside_menu ul:nth-child(1)>li.k-menu__item--submenu'), function() {
                const first = $(this);
                const secondSub = first.find('li.k-menu__item--submenu');

                $.each(secondSub, function() {
                    if (! $(this).find('li.k-menu__item').length) {
                        $(this).remove();
                    }
                });

                if(! first.find('li.k-menu__item').length) {
                    first.remove();
                }
            });
        },
        activeMenuByUrl: () => {
            let currentUrl = window.location.href.split(/[?#]/)[0].replace(/\/*$/, '');
            let menuActiveLinkEl = $(`a.k-menu__link[href="${currentUrl}"]`);
            let urlPaths = window.location.pathname.split('/').filter(path => !isEmpty(path));

            if (! menuActiveLinkEl.length) {
                $('a.k-menu__link').each(function(i, e) {
                    let linkHref = $(e).attr('href');

                    if (linkHref.startsWith('javascript')) {
                        return;
                    }

                    let isActive = (new URL(linkHref)).pathname.split('/').filter(path => !isEmpty(path))[0] == urlPaths[0];

                    if( isActive) {
                        menuActiveLinkEl = $(e);
                        return false;
                    }
                })
            }

            menuActiveLinkEl.closest('li').addClass('k-menu__item--active');
            menuActiveLinkEl.closest('li.k-menu__item--submenu').addClass('k-menu__item--open');
            menuActiveLinkEl.closest('li.k-menu__item--submenu').parent().closest('li.k-menu__item--submenu').addClass('k-menu__item--open');
        },
        renderCountingMenuItemSubtext: () => {
            //
        },
    };

    MENU_CONFIG.init();
</script>
@endpush
