<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thanh toán - {{ data_get($PAGE_SETTINGS, 'title') }}</title>
</head>
<body>
    <link href="{{ asset('frontend/assets/css/common/latest/199.latest.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/latest/661.latest.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/latest/669.latest.css') }}" rel="stylesheet" type="text/css" />

    <div class="app">
        <div style="--swn0j0: rgb(180,169,169); --swn0j1: rgb(0,0,0); --swn0j2: rgb(204,197,197); --swn0j3: rgb(247,246,246); --swn0j6: rgb(108,103,103); --swn0j7: rgb(18,18,18); --swn0j9: rgb(0,0,0); --swn0j8: rgb(0,0,0); --swn0ja: rgb(255,255,255); --swn0jb: rgb(255,255,255); --swn0j25: rgb(180,169,169); --swn0j27: rgb(0,0,0); --swn0j28: rgb(204,197,197); --swn0j29: rgb(247,246,246); --swn0j17: rgb(0, 0, 0); --swn0j2c: rgb(108,103,103); --swn0j2a: rgba(180,169,169,0.05); --swn0j2n: rgba(180,169,169,0.05); --swn0j35: rgba(180,169,169,0.05); --swn0j4i: rgb(180,169,169); --swn0j4k: rgb(0,0,0); --swn0j4l: rgb(204,197,197); --swn0j4m: rgb(247,246,246); --swn0j1p: rgb(0, 0, 0); --swn0j4p: rgb(108,103,103); --swn0j4n: rgba(180,169,169,0.05); --swn0j50: rgba(180,169,169,0.05); --swn0j5i: rgba(180,169,169,0.05);">
            <div class="g9gqqf1 _1fragemfq _1fragemm8 _1fragemex _1fragemf0">
                <div class="_1fragemfc _1frageme0">
                    <div class="_1fragemf0 _1fragemex _1fragemfc _1fragemm8 _1frageme0 MX30i">
                        <a href="#checkout-main" class="dxxRT">Skip to content</a>
                        <div class="_1fragemfi _1fragemdg">
                            <div class="_1frageme0 _1fragemfi _1mrl40q2 _1fragemgb _1fragemgs _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: 1fr; --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(auto, max-content) minmax(0, 1fr) minmax(auto, max-content);">
                                @include('frontend.pages.checkouts.partials.header')

                                <div class="_1fragemfc _1frageme0">
                                    <div class="_1frageme0 _1fragemfi _1mrl40q2 _1fragemgb _1fragemgs _16s97g7c _16s97g7d _16s97g7e _16s97g7k _16s97g718 _16s97g719 _16s97g71a _16s97g71g   _16s97g78a" style="--_16s97g78: minmax(0, 1fr); --_16s97g79: 1fr; --_16s97g7a: 1fr; --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g715: minmax(0, 1fr) minmax(0, 61rem) minmax(0, 1fr); --_16s97g716: minmax(0, 1fr) minmax(0, 65rem) minmax(0, 45.5rem) minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                                        @include('frontend.pages.checkouts.partials.payment')
                                        @include('frontend.pages.checkouts.partials.items')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="_1fragemle">Updated total price: ₫15,466,000 VND</div>
                    </div>
                    <div class=""></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
