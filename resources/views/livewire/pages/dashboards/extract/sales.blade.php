<div>
    <div wire:loading.delay class="overlayLoading">
        <div class="spinner"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Vendas
            </div>
        </div>
    </div>
    <div class="row" style="margin-left: 10px;margin-right: 10px;">
        <div class="col-md-2">
            <div class="form-group">
                <select wire:model="range" class="custom-select" id="range" name="range">
                    <option value="0">Diário</option>
                    <option value="1">Ontem</option>
                    <option value="2">Semanal</option>
                    <option value="3">Mensal</option>
                    <option value="4">Personalizado</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <form wire:submit.prevent="submit">
                <div class="form-row">
                    <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                        <input wire:model="dateStart" type="text"
                               class="form-control @error('dateStart') is-invalid @enderror"
                               id="date_start"
                               name="dateStart"
                               autocomplete="off"
                               maxlength="50"
                               placeholder="Data Inicial"
                               onchange="this.dispatchEvent(new InputEvent('input'))">
                        @error('dateStart')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 @if($range != 4) d-none @endif">
                        <input wire:model="dateEnd" type="text"
                               class="form-control date @error('dateEnd') is-invalid @enderror"
                               id="date_end"
                               name="dateEnd"
                               autocomplete="off"
                               maxlength="50"
                               placeholder="Data Final"
                               onchange="this.dispatchEvent(new InputEvent('input'))">
                        @error('dateEnd')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row bg-white p-3">
        @forelse($dados as $dado)
        <div class="col-sm-12 col-md-4">
            <div class="alert" style="background-color: {{ $dado['gameColor'] }}; color:#FFF;">
                <strong>{{ $dado['gameName'] }}</strong>
                <strong style="float: right;">{{ $dado['fullGain'] }}</strong>
                <hr class="message-inner-separator">
                <p>
                    <button class="btn btn-light btn-block" type="button" data-toggle="collapse"
                            data-target="#dados{{$dado['game']}}" aria-expanded="false"
                            aria-controls="dados{{$dado['game']}}">
                        Ver Dados
                    </button>
                </p>
                <div class="col">
                    <div class="collapse multi-collapse" id="dados{{$dado['game']}}">
                        <div class="card card-body" style="color: #000">
                            <p><strong>Bilhetes Vendidos:</strong> {{ $dado['total'] }}</p>
                            <p><strong>Total Recebido:</strong> {{ $dado['payed'] }}</p>
                            <p><strong>Bilhetes Premiados:</strong> {{ $dado['drawed'] }}</p>
                            <p><strong>Total Pago:</strong> {{ $dado['drawedPayed'] }}</p>
                        </div>

                        <p>
                            <button class="btn btn-light btn-block" type="button" data-toggle="collapse"
                                    data-target="#detalhes{{$dado['game']}}" aria-expanded="false"
                                    aria-controls="detalhes{{$dado['game']}}">
                                Mais Detalhes
                            </button>
                        </p>
                        <div class="col">
                            <div class="collapse multi-collapse" id="detalhes{{$dado['game']}}">
                                @foreach($dado['unities'] as $unities)
                                <div class="card card-body" style="color: #000">
                                    <div class="btn bg-blue light mb-2">
                                        <strong>Dezenas:</strong> {{ $unities['dezenas'] }}
                                    </div>
                                    <div>
                                        <p><strong>Bilhetes Vendidos:</strong> {{ $unities['vendido'] }}</p>
                                        <p><strong>Total Recebido:</strong> {{ $unities['total'] }}</p>
                                        <p><strong>Bilhetes Premiados:</strong> {{ $unities['drawed'] }}</p>
                                        <p><strong>Total Pago:</strong> {{ $unities['payed'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-sm-12"><p>Nenhum jogo vendido.</p></div>
        @endforelse
    </div>
</div>


@push('scripts')
    <style>
        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 9px solid;
            border-color: #dbdcef;
            border-right-color: #32689a;
            animation: spinner-d3wgkg 1s infinite linear;
            margin-left: calc(50% - 56px);
            margin-top: calc(25% - 56px);
        }
        .overlayLoading{
            min-width: 100%;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 99999;
            background-image: repeating-linear-gradient(45deg, #32689a 0, #32689a 3px, transparent 0, transparent 50%);
            background-size: 21px 21px;
            background-color: #333333;
            opacity: .9;
        }

        @keyframes spinner-d3wgkg {
            to {
                transform: rotate(1turn);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
        });

        var i18n = {
            previousMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
        };

        var dateStart = new Pikaday({
            field: document.getElementById('date_start'),
            format: 'DD/MM/YYYY',
            i18n: i18n,
        });
        var dateEnd = new Pikaday({
            field: document.getElementById('date_end'),
            format: 'DD/MM/YYYY',
            i18n: i18n,
        });
    </script>

@endpush
