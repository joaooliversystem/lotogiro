<div>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Detalhes Pedido #{{ $order->reference }}</h4>
        <hr>
        <div class="row">
            <div class="col-sm-12" style="line-height: 3rem;">
                <p class="mb-0"><b>{{ $order->data }}</b></p>
                <p class="mb-0"><b>Recarga: </b> R$ {{ $order->value }}</p>
                <p class="mb-0"><b>Status: </b>{{ $order->statusTxt }}</p>
            </div>
        </div>
    </div>
    @if($order->status != 1)
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-block" href="{{ $order->link }}" target="_blank">Tentar Novamente</a>
        </div>
    </div>
    @endif
</div>
