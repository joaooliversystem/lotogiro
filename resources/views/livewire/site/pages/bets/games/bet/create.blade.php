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
    <form wire:submit.prevent="submit" class="text-left">
        <div class="row mb-2">
            <div class="col-md-12">
                    @if(isset($values) && $values->count() > 0)
                        @foreach($values as $value)
                    <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                    <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                    <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
                    Digite o Valor da Aposta
                    <input wire:model="vv" type="text" id="vv" wire:change="$set('premio', '0')" value="{{old('vv', $vv ?? null)}}" name="vv" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                    Valor do Prêmio R$
                    <input wire:model="premio" type="text" id="premio" value="{{old('premio', $premio ?? null)}}"name="premio" required disabled>
                    <button  class="btn btn-info" wire:click="calcular()" type="button">Calcular</button>
                        @endforeach
                    @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(isset($matriz))
                    <h4>Selecione os números:({{count($selectedNumbers)}}/{{$numbers}})</h4>

                    @if($typeGame->name == "SLG - 15 Lotofácil" || $typeGame->name == "SLG - 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                    <button wire:click="selecionaTudo()" class="btn btn-info" type="button">Seleciona todos os Números</button>
                    @endif
                    
                    <br>
                    <br>
                    {{-- puxar do banco de dados quantos numeros pode se jogar --}}
                    @foreach ($busca as $buscas)
                        <button wire:click="randomNumbers({{ $buscas['numbers'] }})" class="btn btn-dark" type="button">{{ $buscas['numbers'] }}</button>
                    @endforeach   

                    <div class="table-responsive">
                        <table class="table text-center">
                            <tbody>
                            @foreach($matriz as $lines)
                                <tr>
                                    @foreach($lines as $cols)
                                        <td>
                                            <button wire:click="selectNumber({{$cols}})"  type="button"
                                                    class="btn btn-info btn-block {{in_array($cols, $selectedNumbers) ? 'btn-info' : 'btn-warning'}}"
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
                @if($premio > 0 && $vv > 0)
                <button type="submit" id="button_game"
                        class="btn btn-block btn-outline-success">Criar Jogo
                </button>
                    
                @else
                <button type="submit" id="button_game"
                class="btn btn-block btn-outline-success" disabled>Criar Jogo
                </button>
                      
                @endif
            </div>
        </div>
    </form>

</div>


