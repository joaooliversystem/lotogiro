<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">CARTEIRA</h3>
    </div>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Solicitações de Saque
            </div>
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-bordered table-lg">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Responsável</th>
                        @if(\App\Helper\UserValidate::iAmAdmin())
                            <th>Pix</th>
                        @endif
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($withdraws as $withdraw)
                        <tr>
                            <td>{{ $withdraw->data }}</td>
                            <td>{{ $withdraw->responsavel }}</td>
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <th>{{ $withdraw->pix }}</th>
                            @endif
                            <td>{{ $withdraw->value }}</td>
                            <td>{{ $withdraw->statusTxt }}</td>
                            @if(\App\Helper\UserValidate::iAmAdmin())
                            <td width="5%" align="center">
                                @if($withdraw->status === 0)
                                    <button wire:click="withdrawDone({{ $withdraw->id }})" type="button" class="btn
                                        btn-warning">
                                        <i class="fa fa-check-circle"></i>
                                        Feito
                                    </button>
                                @else
                                    <button disabled type="button" class="btn btn-success"><i class="fa
                                    fa-check-circle"></i></button>
                                @endif
                                @endif
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
                                    {{ $withdraws->links() }}
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
            .btn {
                font-size: 9px;
            }

            tbody tr td {
                font-size: 9px;
            }

            tbody tr th {
                font-size: 9px;
            }
        }

        

    </style>
@endpush