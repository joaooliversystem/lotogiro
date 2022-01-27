<div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Recarga - Adicionar Saldo</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div x-data="{}" id="custom-search-input">
                            <form>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-7">
                                                        <h6 class="my-0">Valor a ser adicionado</h6>
                                                        <small class="text-muted">Valor mínimo de R$ 1,00

                                                            <small class="text-muted"><p>O valor inserido, será creditado
                                                                em sua conta assim que formos notificados.</p></small>
                                                        </small>
                                                    </div>

                                                    <div class="col-sm-12 col-md-5 input-group">
                                                        <input wire:model="valueAdd" x-on:focus="formatInput()"
                                                               type="text" name="valueAdd" id="valueAdd"
                                                               class="search-query form-control w-100" placeholder="Valor" />
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="input-group-append">
                                            <button wire:click.prevent="callMP" type="submit"
                                                    @if($valueAdd <= .99) disabled @endif
                                                    class="btn btn-primary btn-lg btn-block">Continuar {{$valueAdd}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('styles')

@endpush

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />

    <script src="https://cdn.jsdelivr.net/npm/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

    <script type="text/javascript">
        function formatInput(){
            VMasker(document.getElementById("valueAdd")).maskMoney();
        }

        function redirect(link){
            window.open(link, "_blank");
            window.location.href = 'recharge-order';
        }
    </script>
@endpush
