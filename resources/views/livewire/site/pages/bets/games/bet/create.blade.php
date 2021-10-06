<div>
    <div>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Tipo</th>
            <th scope="col">Concurso</th>
            <th scope="col">Data do Sorteio</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$typeGame->name}}</td>
            @if(empty($typeGame->competitions->last()))
                <td colspan="2" class="text-danger">NÃO EXISTE CONCURSO CADASTRADO, NÃO É POSSIVEL CRIAR O JOGO</td>
            @else
                <td>{{$typeGame->competitions->last()->number}}</td>
                <td>{{\Carbon\Carbon::parse($typeGame->competitions->last()->sort_date)->format('d/m/Y H:i:s')}}</td>
            @endif
        </tr>
        <tr>
            <td class="text-success" colspan="3">
                {{$typeGame->description}}
            </td>
        </tr>
        </tbody>
    </table>
    <form wire:submit.prevent="store" class="text-left">
        <div class="row mb-2">
            <div class="col-md-12">
                <ul class="list-group list-group-horizontal-sm">
                    @if(isset($values) && $values->count() > 0)
                        @foreach($values as $value)
                            <li class="list-group-item">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input wire:model="value" type="radio" id="value_{{$value->id}}"
                                           value="{{$value->id}}" name="value"
                                           class="custom-control-input @error('value') is-invalid @enderror">
                                    <label class="custom-control-label" for="value_{{$value->id}}">
                                        Valor da Aposta: R${{\App\Helper\Money::toReal($value->value)}}<br/>
                                        Valor do Prêmio: R${{\App\Helper\Money::toReal($value->prize)}}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            Valor da Aposta: R$0 <br/>
                            @error('value')
                            <small class="text-danger" role="alert">
                                É necessario selecionar o valor
                            </small>
                            @enderror
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(isset($matriz))
                    <h4>Selecione os números:({{count($selectedNumbers)}}/{{$numbers}})</h4>
                    @if($typeGame->name == "Lotogiro - 15 Lotofácil" || $typeGame->name == "Lotogiro 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                    <button wire:click="selecionaTudo()" class="btn btn-success" type="button">Seleciona todos os Números</button>
                    @endif
                    <div class="table-responsive">
                        <table class="table text-center">
                            <tbody>
                            @foreach($matriz as $lines)
                                <tr>
                                    @foreach($lines as $cols)
                                        <td>
                                            <button wire:click="selectNumber({{$cols}})" type="button"
                                                    class="btn btn-success btn-block {{in_array($cols, $selectedNumbers) ? 'btn-success' : 'btn-warning'}}"
                                                    id="number_{{$cols}}">
                                                {{$cols}}
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="button_game"
                        class="btn btn-block btn-outline-success">Criar Jogo
                </button>
            </div>
        </div>
    </form>
</div>


