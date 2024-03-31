<div class="col-lg-4 col-sm-4">
    <div class="k-portlet sticky-top" id="sticky-portlet" style="top: 100px;z-index: 1">
        <div class="k-portlet__body k-portlet__body--fit">
            <ul class="k-nav k-nav--bold k-nav--md-space k-nav--v3 k-margin-t-20 k-margin-b-20 nav nav-tabs">
                @foreach ($groups as $group)
                <li class="k-nav__item group-tab-item" id="group-tab-{{ data_get($group, 'id') }}">
                    <a
                        class="k-nav__link section_groupSettingItem {{ empty($tab) ? ( $loop->index+1 == $loop->first ? 'active' : '') : ($tab == data_get($group, 'id') ? 'active' : '') }}"
                        data-toggle="tab"
                        data-tab="{{ data_get($group, 'id') }}"
                        href="#tab_{{ data_get($group, 'id') }}"

                    >
                        <span class="k-nav__link-text">{{ __(data_get($group, 'name_display')) }}</span>
                        @can('system-settings.delete')
                        <button
                            type="button"
                            data-confirmable="{{ __('Are you sure you want to delete this group?') }}"
                            data-success-message="{{ __('Delete setting group success.') }}"
                            data-method="DELETE"
                            data-url="{{ route('bo.api.system-settings.delete.group', data_get($group, 'id')) }}"
                            class="btn btn-link btn-sm actionBtn"
                        >
                            <i class="fas fa-times pl-1"></i>
                        </button>
                        @endcan
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
