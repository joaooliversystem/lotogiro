<div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Tipo</th>
            <th scope="col">Concurso</th>
            <th scope="col">Data do Sorteio</th>
            <th scope="col">Importar Jogo</th>
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
            <td> <a href="{{route('admin.bets.games.carregarjogo', ['type_game' => $typeGame->id])}}"><button  class="btn btn-primary" type="button">Carregar </button></a></td>
            
            @endif
        </tr>
        </tbody>
    </table>

{{-- <div wire:ignore>
    @if($teste['type_client'] == 2)

    <input type="text" value="{{ $teste['name'] }}" disabled class="form-control">
    <input type="hidden" name="client" value="{{ $clientId }}">

    @endif
</div>

@if($teste['type_client'] == 2)
    <input type="hidden" name="numbers" id="numbers" value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach" readonly>
    <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
@endif

@if($teste['type_client'] == 1) --}}

    {{-- INPUT DO SEARCH SE NÃO TIVER AUTENTICADO --}}

    <div class="form-row">
        <div class="form-group col-md-12">
            <div wire:ignore>
                <h4>Cliente</h4>
            </div>        
        <div class="dropdown-divider"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <input wire:model="search" type="text" id="author" class="form-control" placeholder="Pesquisar Cliente" autocomplete="off">
                        <div class="input-group-append">
                            <span wire:click="clearUser" class="input-group-text" title="Limpar"><i class="fas fa-user-times"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        
        {{-- PARTE DE PESQUISA DE CLIENTE SE NÃO TIVER AUTENTICAÇÃO --}}

        <input type="hidden" name="client" value="{{$clientId}}">
            <div class="row mb-3" id="list_group" style="max-height: 100px; overflow-y: auto">
                <div class="col-md-12">
                    @if($showList)
                        <ul class="list-group">
                            @if(isset($clients) && $clients->count() > 0)
                            {{-- <h2>$client</h2> --}}
                            @foreach($clients as $client)
                                <li wire:click="setId({{ $client }})"
                                    {{-- class="list-group-item" style="cursor:pointer;">{{ $client->name . ' - ' . \App\Helper\Mask::addMaskCpf($client->cpf) . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)}} </li> --}}
                                    class="list-group-item" style="cursor:pointer;">{{ $client->name . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)}} </li>
                            @endforeach
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            <input type="hidden" name="numbers" id="numbers" value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach" readonly>
            </div>
        <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
    </div>

    {{-- @endif --}}

        {{-- PARTE DE CALCULO DE VALORES DO JOGO --}}

    <div class="row mb-2">
        <div class="col-md-12">
                @if(isset($values) && $values->count() > 0)
                    @foreach($values as $value)
                        <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                        <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                        <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
                        Digite o Valor da Aposta
                        <input type="text" id="value" onchange="altera()" value="" name="value" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        Valor do Prêmio R$
                        <input type="text" id="premio" value="" name="premio" readonly>
                        <button  class="btn btn-info" type="button" onclick="altera();">Calcular</button>
                    @endforeach
                @else
                
                @endif
        </div>
    </div>

    {{-- PARTE DE ESCOLHER NUMEROS DO  JOGO --}}
    <div class="row">
        <div class="col-md-12">
            @if(isset($matriz))
                <h4>Selecione os números:({{count($selectedNumbers)}}/{{$numbers}})</h4>
                    @if($typeGame->name == "BR - Lotofácil 15" || $typeGame->name == "BR - LotoMania 20" || $typeGame->name == "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                      <button wire:click="selecionaTudo()" class="btn btn-info" type="button" onclick="limpacampos();">Seleciona todos os Números</button>
                    @endif

                    <br>
                    <br>
                    
                    {{-- puxar do banco de dados quantos numeros pode se jogar --}}
                    @foreach ($busca as $buscas)
                        <button style="margin-top: 1%" wire:click="randomNumbers({{ $buscas['numbers'] }})" class="btn btn-dark" type="button">{{ $buscas['numbers'] }}</button>
                    @endforeach 

         

                <div class="table-responsive">
                    <table class="table  text-center">
                        <tbody>
                        @foreach($matriz as $lines)
                            <tr>
                                @foreach($lines as $cols)
                                    <td>
                                        <button wire:click="selectNumber({{$cols}})" id="number_{{$cols}}" type="button"
                                                class="btn btn-info {{in_array($cols, $selectedNumbers) ? 'btn-info' : 'btn-warning'}} btn-beat-number">{{$cols}}</button>
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
</div>

@push('styles')
    <link href="{{asset('admin/layouts/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}" rel="stylesheet"/>

    <style>
        .btn-beat-number {
            width: 100%;
        }
    </style>

@endpush

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

{{-- <script>
        $(document).ready(function () {
            $('#clients').select2({
                theme: "bootstrap"
            });
            $('#sort_date').inputmask("99/99/9999 99:99:99");
        });
    </script> --}}
    
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



         function mudarListaNumeros(){
            var input = document.querySelector("#numbers");
            var NovoTexto = input.value;
            console.log(NovoTexto);
            var NovoTexto = NovoTexto.trim();
            var NovoTexto = NovoTexto.split("  ");
            var NovoTexto = NovoTexto.toString();
            console.log(NovoTexto);
            document.getElementById('numbers').value = NovoTexto;

         }

         function mudarListaNumerosGeral(){
             altera();
             mudarListaNumeros();

         }

         function limpacampos(){
            var valor = document.getElementById("value").value;
            var Campovalor = document.getElementById("value");
            var campoDoCalculo = document.getElementById("premio");
            campoDoCalculo.value = "";
            Campovalor.value = "";
         }

    </script>

@endpush

