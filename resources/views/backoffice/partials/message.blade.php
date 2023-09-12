@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert_' . $msg))
        <div class="alert alert-{{ $msg }} fade show" role="alert">
            <div class="alert-text">{{ Session::get('alert_' . $msg) }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="la la-close"></i></span>
                </button>
            </div>
        </div>
    @endif
@endforeach


@if($errors->any())
<div class="alert alert-danger fade show" role="alert">
    <div class="alert-text">
        <ul>
        @foreach ($errors->getBags() as $bag)
            @foreach ($bag->getMessages() as $messages)
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endforeach
        @endforeach
        </ul>
    </div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="la la-close"></i></span>
        </button>
    </div>
</div>
@endif
