<div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <h4 class="my-4">Pedidos de Recarga</h4>
                <table class="table table-striped table-hover table-bordered table-lg">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->data }}</td>
                            <td>{{ $order->user }}</td>
                            <td>{{ $order->value }}</td>
                            <td>{{ $order->statusTxt }}</td>
                            <td width="5%" align="center">
                                <a href="{{ route('admin.dashboards.wallet.order-detail', $order->reference) }}"
                                   type="button"
                                   class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                    Detalhes
                                </a>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
