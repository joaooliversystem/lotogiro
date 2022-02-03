<div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <h4 class="my-4">Extrato de Saldo | {{ auth()->user()->name }} - Saldo Total: {{ \App\Helper\Money::toReal
                (auth()->user()->balance) }}</h4>
                <table x-data="{data: @entangle('trasacts')}" class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Responsável</th>
                        <th>Valor</th>
                        <th>Valor Anterior</th>
                        <th>Observações</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template x-for="history in data">
                            <tr>
                                <td x-text="history.data"></td>
                                <td x-text="history.responsavel"></td>
                                <td x-text="history.value"></td>
                                <td x-text="history.old_value"></td>
                                <td x-text="history.obs"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['prev'] }}" class="btn btn-dark btn-block
                                        @if(is_null($paginate['prev'])) disabled @endif">Anterior</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['next'] }}" class="btn btn-dark btn-block
                                        @if(is_null($paginate['next'])) disabled @endif">Próxima</a>
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
