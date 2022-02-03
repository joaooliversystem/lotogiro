<div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Carteira - Transferência de Saldo</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4>Procurar contato para transferência</h4>
                    </div>
                    <div class="col-12">
                        <div id="custom-search-input">
                            <form wire:submit.prevent="searchClient()">
                                <div class="input-group">
                                    <input wire:model.defer="searchPhrase" type="text" class="search-query form-control"
                                           placeholder="Buscar" />
                                    <button type="submit" class="btn btn-dark">
                                        <span class="fa fa-search" style="color: #fff938"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-data="{data: @entangle('client')}">
                    <template x-if="data">
                        <form wire:submit.prevent="transferToClient()">
                            <div class="row mt-5">
                                <div class="col-sm-7">
                                    <h6>Dados do Recebedor</h6>
                                    <div class="col-sm-12">
                                        <b>Nome: </b> <span x-text="data.name"></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <b>E-Mail: </b> <span x-text="data.email"></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <b>Telefone: </b> <span x-text="data.phone"></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <b>Salvar contato? </b>

                                        <div x-data="{storeContact: @entangle('storeContact').defer}" class="col-sm-5">
                                            <button x-on:click.prevent="storeContact = !storeContact" type="button"
                                                class="btn btn-sm btn-toggle active" data-toggle="button"
                                                aria-pressed="true" autocomplete="off">
                                                <div class="handle"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <h6>Valor a transferir</h6>
                                    <div class="input-group">
                                        <input wire:model="valueTransfer" x-on:focus="formatInput()" type="text"
                                           class="search-query form-control" placeholder="Valor a transferir"
                                           id="valueTransfer" inputmode="numeric" value="0,00" />
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="input-group">
                                        <button wire:click="transferBalance" type="button" class="btn btn-dark
                                        btn-block">
                                            Transferir <span class="fa fa-send" style="color: #fff938"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </template>
                    <template x-if="!data">
                        <div class="alert alert-warning mt-5" role="alert">
                            Nenhum usuário selecionado para efetuar a transferência.
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>


@push('styles')
    <style>
        .btn-toggle {
            margin: 0 4rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle:focus,
        .btn-toggle.focus,
        .btn-toggle:focus.active,
        .btn-toggle.focus.active {
            outline: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            line-height: 1.5rem;
            width: 4rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle:before {
            content: "Não";
            left: -4rem;
        }
        .btn-toggle:after {
            content: "Sim";
            right: -4rem;
            opacity: 0.5;
        }
        .btn-toggle > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.active:before {
            opacity: 0.5;
        }
        .btn-toggle.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            display: none;
        }
        .btn-toggle:before,
        .btn-toggle:after {
            color: #6b7381;
        }
        .btn-toggle.active {
            background-color: #29b5a8;
        }
        .btn-toggle.btn-lg {
            margin: 0 5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 2.5rem;
            width: 5rem;
            border-radius: 2.5rem;
        }
        .btn-toggle.btn-lg:focus,
        .btn-toggle.btn-lg.focus,
        .btn-toggle.btn-lg:focus.active,
        .btn-toggle.btn-lg.focus.active {
            outline: none;
        }
        .btn-toggle.btn-lg:before,
        .btn-toggle.btn-lg:after {
            line-height: 2.5rem;
            width: 5rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-lg:before {
            content: "Não";
            left: -5rem;
        }
        .btn-toggle.btn-lg:after {
            content: "Sim";
            right: -5rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-lg > .handle {
            position: absolute;
            top: 0.3125rem;
            left: 0.3125rem;
            width: 1.875rem;
            height: 1.875rem;
            border-radius: 1.875rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-lg.active > .handle {
            left: 2.8125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-lg.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-lg.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-sm:before,
        .btn-toggle.btn-lg.btn-sm:after {
            line-height: 0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.6875rem;
            width: 3.875rem;
        }
        .btn-toggle.btn-lg.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-lg.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-lg.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-lg.btn-xs:before,
        .btn-toggle.btn-lg.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-sm {
            margin: 0 0.5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
        }
        .btn-toggle.btn-sm:focus,
        .btn-toggle.btn-sm.focus,
        .btn-toggle.btn-sm:focus.active,
        .btn-toggle.btn-sm.focus.active {
            outline: none;
        }
        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: 1.5rem;
            width: 0.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-sm:before {
            content: "Não";
            left: -0.5rem;
        }
        .btn-toggle.btn-sm:after {
            content: "Sim";
            right: -0.5rem;
            opacity: 0.5;
        }
        .btn-toggle.btn-sm > .handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-sm.active > .handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-sm.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-sm:before,
        .btn-toggle.btn-sm.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }
        .btn-toggle.btn-sm.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-sm.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-sm.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-sm.btn-xs:before,
        .btn-toggle.btn-sm.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-xs {
            margin: 0 0;
            padding: 0;
            position: relative;
            border: none;
            height: 1rem;
            width: 2rem;
            border-radius: 1rem;
        }
        .btn-toggle.btn-xs:focus,
        .btn-toggle.btn-xs.focus,
        .btn-toggle.btn-xs:focus.active,
        .btn-toggle.btn-xs.focus.active {
            outline: none;
        }
        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            line-height: 1rem;
            width: 0;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }
        .btn-toggle.btn-xs:before {
            content: "Não";
            left: 0;
        }
        .btn-toggle.btn-xs:after {
            content: "Sim";
            right: 0;
            opacity: 0.5;
        }
        .btn-toggle.btn-xs > .handle {
            position: absolute;
            top: 0.125rem;
            left: 0.125rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 0.75rem;
            background: #fff;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active {
            transition: background-color 0.25s;
        }
        .btn-toggle.btn-xs.active > .handle {
            left: 1.125rem;
            transition: left 0.25s;
        }
        .btn-toggle.btn-xs.active:before {
            opacity: 0.5;
        }
        .btn-toggle.btn-xs.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-sm:before,
        .btn-toggle.btn-xs.btn-sm:after {
            line-height: -1rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.275rem;
            width: 1.55rem;
        }
        .btn-toggle.btn-xs.btn-sm:before {
            text-align: right;
        }
        .btn-toggle.btn-xs.btn-sm:after {
            text-align: left;
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:before {
            opacity: 0;
        }
        .btn-toggle.btn-xs.btn-sm.active:after {
            opacity: 1;
        }
        .btn-toggle.btn-xs.btn-xs:before,
        .btn-toggle.btn-xs.btn-xs:after {
            display: none;
        }
        .btn-toggle.btn-secondary {
            color: #6b7381;
            background: #bdc1c8;
        }
        .btn-toggle.btn-secondary:before,
        .btn-toggle.btn-secondary:after {
            color: #6b7381;
        }
        .btn-toggle.btn-secondary.active {
            background-color: #ff8300;
        }
    </style>
@endpush

@push('scripts')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />

    <script src="https://cdn.jsdelivr.net/npm/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

    <script type="text/javascript">
        function formatInput(){
            VMasker(document.getElementById("valueTransfer")).maskMoney();
        }
    </script>
@endpush
