<div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Carteira</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Saldo: R${{ \App\Helper\Money::toReal(auth()->user()->balance) }}</h4>
                    </div>
                    <div class="col-sm-4 right">
                        <a href="{{ route('admin.dashboards.extracts.index') }}" type="button" class="btn btn-block btn-dark text-light
                        text-bold">Extrato</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-4">
                        <a href="{{ route('admin.dashboards.wallet.transfer') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Transferir</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Recarregar</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.dashboards.wallet.withdraw') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Retirar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
