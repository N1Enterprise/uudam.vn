@if($hasVariant && empty($inventory->id))
<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('NHÓM PHÂN LOẠI') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                @include('backoffice.pages.inventories.partials.variant')
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label text-lowercase">
                    @php
                        $invAttrs = $inventory->attributes;
                        $invAttrVals = $inventory->attributeValues->pluck('value', 'attribute_id')->toArray();

                        $invAttrTitles = optional($invAttrs)->map(function($attr) use ($invAttrVals) {
                            return data_get($attr, 'name') .': '. data_get($invAttrVals, data_get($attr, 'id'), '');
                        });

                    @endphp
                    <h3 class="k-portlet__head-title font-weight-bold">{{ optional($invAttrTitles)->isEmpty() ? __('KHÔNG CÓ BIẾN THỂ') : $invAttrTitles->implode(', ') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                @include('backoffice.pages.inventories.partials.simple')
            </div>
        </div>
    </div>
</div>
@endif
