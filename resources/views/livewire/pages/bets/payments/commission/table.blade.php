<div>
    <div class="col-md-12 p-4 faixa-jogos">
        <h3 class="text-center text-bold">COMISSÕES</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="col-md-1 commisao-icon text-center">
                        <i class="fas fa-calendar nav-icon"></i>
                    </div>
                    <div class="col-md-11 commisao-input">
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
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-1 commisao-icon text-center">
                        <i class="fas fa-calendar nav-icon"></i>
                    </div>
                    <div class="col-md-11 commisao-input">
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <input wire:model="search" type="text" id="author" class="form-control" placeholder="Pesquisar Usuário"
                       autocomplete="off">
                <div class="input-group-append">
                    <span wire:click="clearUser" class="input-group-text" title="Limpar"><i
                            class="fas fa-user-times"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3" style="max-height: 100px; overflow-y: auto">
        <div class="col-md-12">
            @if($showList)
                <ul class="list-group">
                    @foreach($users as $user)
                        <li wire:click="setId({{ $user }})"
                            class="list-group-item"
                            style="cursor:pointer;">{{ $user->name . ' ' . $user->last_name . ' - ' . $user->email}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="row">
        <div wire:loading wire:target="pay" class="col-md-12 text-center">
            <div class="alert alert-warning" role="alert">
                <button class="btn" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Baixando Pagamentos
                </button>
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
        <div class="form-group offset-md-5 col-md-6 text-right">
            <button wire:click="pay" type="button" class="btn btn-danger">Baixar Pagamento</button>
        </div>
    </div>
    <div class="card card-info">
        <div class="card-header indica-card">
            <h3 class="card-title">Informações de Pagamento</h3>
        </div>
        <div class="card-body">
            <div class="row">
                    <div class="col-md-3">   
                        <b>Quantidade:</b> {{$games->count()}}
                    </div>
                    <div class="col-md-3">
                        <b>Vendas:</b> R${{\App\Helper\Money::toReal($value)}} 
                    </div>
                    <div class="col-md-3">
                        <b>Bonus:</b> R${{\App\Helper\Money::toReal($valueBonus)}} 
                    </div>
                    <div class="col-md-3">
                        <b>Total:</b> R${{\App\Helper\Money::toReal($value + $valueBonus)}}
                    </div>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-12 extractable-cel">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm" id="game_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo de Jogo</th>
                        <th>Cpf Cliente</th>
                        <th>Cliente</th>
                        <th>Usuário</th>
                        <th>Valor</th>
                        <th>%</th>
                        <th>Comissão</th>
                        <th>Criação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($games as $game)
                        <tr>
                            <td>
                                {{ $game->id }}
                            </td>
                            <td>
                                {{ $game->typeGame->name }}
                            </td>
                            <td>
                                {{ \App\Helper\Mask::addMaskCpf($game->client->cpf) }}
                            </td>
                            <td>
                                {{ $game->client->name . ' ' . $game->client->last_name }}
                            </td>
                            <td>
                                {{ $game->user->name . ' ' . $game->user->last_name }}
                            </td>
                            <td>
                                {{ 'R$' . \App\Helper\Money::toReal($game->value) }}
                            </td>
                            <td>
                                {{ $game->commission_percentage ?? 0 }}%
                            </td>
                            <td>
                                {{ 'R$' . \App\Helper\Money::toReal($game->commission_value) }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($game->created_at)->format('d/m/Y') }}
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
                {{ $games->links() }}
            </div>
        </div>
    </div>
</div>


@push('scripts')

    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    <script>
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
