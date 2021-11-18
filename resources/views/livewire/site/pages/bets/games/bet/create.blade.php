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
                    <input wire:model="vv" type="text" id="vv" value="{{old('vv', $vv ?? null)}}" name="vv" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                    Valor do Prêmio R$
                    <input wire:model="premio" type="text" id="premio" value="{{old('premio', $premio ?? null)}}"name="premio" disabled>
                    <button  class="btn btn-success" wire:click="calcular()" type="button">Calcular</button>
                        @endforeach
                    @endif
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
<script>
     //Função para realizar o calculo do multiplicador
         function altera(){
            var multiplicador = document.getElementById("multiplicador").value;
            var valor = document.getElementById("value").value;
            var Campovalor = document.getElementById("value");
            var campoDoCalculo = document.getElementById("premio");
            var maxreais = document.getElementById("maxreais").value;
            var resultado;
            var numberValor = parseInt(valor);
            var numberReais = parseInt(maxreais);

            //evento dispara quando retira o foco do campo texto
                if( numberReais >= numberValor ){
                 resultado = valor * multiplicador;
                campoDoCalculo.value = resultado;
                }else{
                resultado = maxreais * multiplicador;
                campoDoCalculo.value = resultado;
                Campovalor.value = maxreais;
                }
            
         }
</script>

