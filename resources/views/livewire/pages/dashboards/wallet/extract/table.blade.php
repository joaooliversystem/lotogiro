<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">CARTEIRA</h3>
    </div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Extrato de Saldo | {{ auth()->user()->name }} - Saldo Total: {{ \App\Helper\Money::toReal
                (auth()->user()->balance) }}
            </div>
            <div class="table-responsive extractable-cel" >
                
                <table x-data="{data: @entangle('trasacts')}" class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Responsável</th>
                        <th>Valor</th>
                        <th>Valor Anterior</th>
                        <th>Obs</th>
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
                                    <a href="{{ $paginate['prev'] }}" class="btn btn-info btn-block
                                        @if(is_null($paginate['prev'])) disabled @endif">Anterior</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ $paginate['next'] }}" class="btn btn-info btn-block
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

@push('styles')
    <style>

        @media screen and (max-width: 760px) {
            
            .btn-info {
                margin-bottom: 10px;
            }

            .indica-card {
                font-size: 13px;
            }
        }

    </style>
@endpush