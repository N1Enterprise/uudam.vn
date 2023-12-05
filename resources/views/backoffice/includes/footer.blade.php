<div class="k-footer k-grid__item k-grid k-grid--desktop k-grid--ver-desktop">
	<div class="k-footer__copyright">
		{{ today()->year }}&nbsp;&copy;&nbsp;<a href="javascript:;" class="k-link">{{ __($APP_NAME) }}</a>
	</div>
    @if($footerMenu)
    <div class="k-footer__menu">
		<a href="javascript:;" class="k-footer__menu-link k-link" style="font-weight: bold;">{{ $footerMenu }}</a>
	</div>
    @endif
</div>
