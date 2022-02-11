<div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <h4 class="my-4">Recargas manuais</h4>
                <table class="table table-striped table-hover table-bordered table-lg">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($transacts as $transact)
                        <tr>
                            <td>{{ $transact->data }}</td>
                            <td>{{ $transact->user }}</td>
                            <td>{{ $transact->value }}</td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{ $transacts->links() }}
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
