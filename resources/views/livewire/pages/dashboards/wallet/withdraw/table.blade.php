<div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Carteira - Transferência de Saldo</h3>
            </div>
            <div class="card-body">
                <div x-data="{data: @entangle('user')}">
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
                                    <b>PIX: </b>
                                    <small>Ao alterar essa informação, ela passa a ser sua principal.</small>
                                </div>
                                <div class="col-sm-12">
                                    <input wire:model.defer="pixSaque" class='col-sm-10' type="text" />
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <h6>Valor a retirar</h6>
                                <small class="text-muted">Valor mínimo de R$ 1,00

                                    <small class="text-muted"><p>O valor inserido, será creditado
                                            em sua conta assim que formos notificados.</p></small>
                                </small>
                                <div class="input-group">
                                    <input wire:model="valueTransfer" x-on:focus="formatInput()" type="text"
                                           class="search-query form-control" placeholder="Valor a retirar"
                                           id="valueTransfer" inputmode="numeric" value="0,00" />
                                </div>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <div class="input-group">
                                    <button wire:click="requestWithdraw" type="button" class="btn btn-dark btn-block"
                                            @if($valueTransfer <= .99) disabled @endif>
                                        Solicitar <span class="fa fa-send" style="color: #fff938"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


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
