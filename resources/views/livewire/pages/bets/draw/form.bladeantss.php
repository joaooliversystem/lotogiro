<div>
    <div class="row">
        <div class="col-md-12">
            @error('success')
            @push('scripts')
                <script>
                    toastr["success"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            @error('error')
            @push('scripts')
                <script>
                    toastr["error"]("{{ $message }}")
                </script>
            @endpush
            @enderror
        </div>
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Sorteio</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store" action="{{route('admin.bets.draws.store')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="type_game">Tipo de Jogo</label>
                                <select wire:model="typeGame"
                                        class="custom-select @error('typeGame') is-invalid @enderror" name="typeGame"
                                        id="type_game">
                                    <option selected value="">Selecione o Tipo de Jogo</option>
                                    @if(isset($typeGames) && $typeGames->count() > 0)
                                        @foreach($typeGames as $typeGame)
                                            <option
                                                value="{{$typeGame->id}}">{{$typeGame->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('typeGame')
                                <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="competition">Concurso</label>
                                <select wire:model="competition"
                                        class="custom-select @error('competition') is-invalid @enderror"
                                        name="competition"
                                        id="competition">
                                    <option selected value="">Selecione</option>
                                    @if(isset($competitions) && $competitions->count() > 0)
                                        @foreach($competitions as $competition)
                                            <option
                                                value="{{$competition->id}}">{{$competition->number}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('competition')
                                <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-7">
                                <label for="numbers">Numeros sorteados <small>(Separados por virgula)</small></label>
                                <input wire:model="numbers" type="text"
                                       class="form-control @error('numbers') is-invalid @enderror" id="numbers"
                                       name="numbers"
                                       maxlength="50" value="{{old('numbers', $typeGame->name ?? null)}}">
                                @error('numbers')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-block btn-outline-success">
                                    <span wire:loading.class="spinner-grow spinner-grow-sm" wire:target="store" class=""
                                          role="status" aria-hidden="true"></span>
                                    <span>Buscar Ganhadores</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    @if(!empty($draw))
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <h3>Sorteio registrado</h3>
                                    <p>
                                        Id: {{$draw->id}}<br/>
                                        Concurso: {{$draw->competition}}<br/>
                                        Numeros: {{$draw->numbers}}<br/>
                                        Jogos Ganhadores: {{!empty($draw->games) ? $draw->games : 'Não houve'}}<br/>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm" id="result_table">
                            <thead>
                            <tr>
                                <th>Jogo</th>
                                <th>Cpf</th>
                                <th>Nome</th>
                                <th>Valor Aposta</th>
                                <th>Valor Prêmio</th>
                                <th>Recibo</th>
                            </tr>
                            </thead>
                            @if(isset($games))
                                <tbody>
                                @if($games->count() > 0)
                                    @foreach($games as $game)
                                        <tr>
                                            <td>{{$game->id}}</td>
                                            <td>{{\App\Helper\Mask::addMaskCpf($game->client->cpf)}}</td>
                                            <td>{{$game->client->name . ' ' . $game->client->last_name}}</td>
                                            <td>{{\App\Helper\Money::toReal($game->typeGameValue->value)}}</td>
                                            <td>{{\App\Helper\Money::toReal($game->typeGameValue->prize)}}</td>
                                            <td width="180">
                                                <a href="{{route('admin.bets.games.receipt', ['game' => $game->id, 'format' => 'pdf', 'prize' => true])}}">
                                                    <button class="btn btn-info btn-sm">
                                                        Gerar Pdf
                                                    </button>
                                                </a>
                                                <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'txt', 'prize' => true])}}">
                                                    <button type="button" class="btn btn-info btn-sm">
                                                        Gerar Txt
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="5"> Não houve nenhum ganhador para os números: {{$numbers}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            @endif
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
