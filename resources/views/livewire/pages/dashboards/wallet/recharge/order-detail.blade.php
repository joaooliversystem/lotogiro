<div>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Detalhes Pedido #{{ $order->reference }}</h4>
        <hr>
        <div class="row">
            <div class="col-sm-12" style="line-height: 3rem;">
                <p class="mb-0"><b>Última atualização: {{ $order->data }}</b></p>
                <p class="mb-0"><b>Usuário: {{ $order->usuario }}</b></p>
                <p class="mb-0"><b>Recarga: </b> R$ {{ $order->value }}</p>
                <p class="mb-0"><b>Status: </b>{{ $order->statusTxt }}</p>
            </div>
        </div>
    </div>

    @if($allOrder->count() > 1)
    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($allOrder as $item)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $item->data }}</td>
                    <td>{{ $item->statusTxt }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($order->status != 1)
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-block" href="{{ $order->link }}" target="_blank">Tentar Novamente</a>
        </div>
    </div>
    @endif
</div>
