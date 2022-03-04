<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-header indica-card">
                Período
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <select wire:model="range" class="custom-select" id="range" name="range">
                    <option></option>
                    <option value="1">Mensal</option>
                    <option value="2">Semanal</option>
                    <option value="3">Diário</option>
                    <option value="4">Personalizado</option>
                </select>
            </div>
        </div>
        <div class="col-md-8">
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
    <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$extracts->count()}}</h3>
                    <p>Quantidade de Transações</p>
                </div>
                <div class="icon">
                    <i class="fas fa-balance-scale-left"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box @if($value < 0) bg-danger @else bg-success @endif">
                <div class="inner">
                    <h3>R${{\App\Helper\Money::toReal($value)}}</h3>
                    <p>Saldo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <span class="small-box-footer p-2"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-1">
            <select wire:model="perPage" class="custom-select" id="per_page">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="form-group offset-md-8 col-md-3">
            <button wire:click="getReport" type="button" class="btn btn-info btn-block">Gerar Relatório</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 extractable-cel">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="game_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th>Usuário</th>
                        <th>Cliente</th>
                        <th>Criação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($extracts as $extract)
                        <tr>
                            <td>
                                {{ $extract->id }}
                            </td>
                            <td>
                                @if($extract->type == 1)
                                    <span class="text-success">Crédito</span>
                                @elseif($extract->type == 2)
                                    <span class="text-danger">Débito</span>
                                @endif
                            </td>
                            <td>
                                R${{ \App\Helper\Money::toReal($extract->value) }}
                            </td>
                            <td>
                                {{ $extract->description }} do tipo: {{$extract->typeGame->name ?? null}}
                            </td>
                            <td>
                                {{ !empty($extract->user->name) ? $extract->user->name .' '. $extract->user->last_name: null }}
                            </td>
                            <td>
                                {{ !empty($extract->client->name) ? $extract->client->name .' '. $extract->client->last_name: null }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($extract->created_at)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $extracts->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>


    <script>

        $(document).ready(function () {
            $('#user').select2({
                theme: "bootstrap"
            });
            $('#range').select2({
                placeholder: "Please select a country"
            });
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
