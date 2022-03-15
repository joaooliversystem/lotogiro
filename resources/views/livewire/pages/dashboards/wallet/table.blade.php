<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">CARTEIRA</h3>
    </div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header indica-card">
                <h3 class="card-title">Carteira</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Saldo: R${{ \App\Helper\Money::toReal(auth()->user()->balance) }}</h4>
                        <h4>Bônus: R${{ \App\Helper\Money::toReal(auth()->user()->bonus) }}</h4>

                    </div>
                    <div class="col-sm-4 right">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">
                            <i class="fas fa-piggy-bank"></i>
                            Recarregar
                        </a>
                        <a href="{{ route('admin.dashboards.wallet.withdraw') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">
                            <i class="fas fa-money-bill-alt"></i>
                            Retirar
                        </a>

                        <a href="{{ route('admin.dashboards.wallet.convert') }}" type="button" class="btn btn-block btn-success
                        text-light
                        text-bold">
                            <i class="fas fa-exchange-alt"></i>
                            Converter
                        </a>
                        
                    </div>
                </div>

               <div class="row mt-5">
                   <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.extract') }}" type="button" class="btn btn-block btn-dark text-light
                            text-bold">Extrato</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.withdraw-list') }}" type="button" class="btn
                        btn-block btn-outline-secondary text-black
                            text-bold">Solicitações de saque</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                       <a href="{{ route('admin.dashboards.wallet.recharge-order') }}" type="button" class="btn
                        btn-block btn-outline-secondary text-black
                            text-bold">Pedidos de Recarga</a>
                    </div>
                </div>
                 <!-- <div class="row mt-5">
                   <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.transfer') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Transferir</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Recarregar</a>
                    </div>
                    <div class="col-sm-4 bt-esp">
                        <a href="{{ route('admin.dashboards.wallet.withdraw') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">Retirar</a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
@endpush
