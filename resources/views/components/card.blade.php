<div class="card {{ !empty($variant) ? 'card-'.$variant : '' }} {{ !empty($outline) ? 'card-outline'.$outline : '' }} ">
    @if (!empty($title))
        <div class="card-header">
            <h3 class="card-title"> {{ $title }} </h3>
        </div>
    @endif

    @if (!empty($header))
        <div class="card-header">
            {!! $header !!}
        </div>
    @endif

    @if (!empty($body))
        <div class="card-body">
            {!! $body !!}
        </div>
    @endif

    @if (!empty($footer))
        <div class="card-footer">
            {!! $footer !!}
        </div>
    @endif
</div>