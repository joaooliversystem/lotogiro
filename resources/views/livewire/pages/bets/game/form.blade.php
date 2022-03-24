<div>
    <table class="table px-sorteio">
        <thead>
        <tr>
            <th class="col1" scope="col">Tipo</th>
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
                <td> <a href="{{route('admin.bets.games.carregarjogo', ['type_game' => $typeGame->id])}}"><button  class="btn btn-info" type="button">Carregar </button></a></td>
            @endif
        </tr>
        </tbody>
    </table>

    @if($User['type_client'] == 1)

    <input type="text" value="{{ $FiltroUser['name'] }}" disabled class="form-control">
    <input type="hidden" name="client" value="{{ $FiltroUser['id'] }}" readonly>

    @endif


    @if($User['type_client'] == 1)
        <input type="hidden" name="numbers" id="numbers" value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach" readonly>
        <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}" readonly>
    @endif

@if($User['type_client'] == null)

    {{-- INPUT DO SEARCH SE NÃO TIVER AUTENTICADO --}}

    <div class="form-row">
        <div class="form-group col-md-12">
            <div wire:ignore>
                <div class="card-header ganhos-card">
                    <h4>Cliente</h4>
                </div>
            </div>        
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
                                    @foreach($clients as $client)
                                        <li wire:click="setId({{ $client }})"
                                            class="list-group-item" style="cursor:pointer;">{{ $client->name . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)}} </li>
                                    @endforeach
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            <input type="hidden" name="numbers" id="numbers" value="@foreach ($selectedNumbers as $selectedNumbers1) {{ $selectedNumbers1 }} @endforeach" readonly>
            </div>
        <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}" readonly>
    </div>

    @endif

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
                <h4>Quantidade selecionada:({{count($selectedNumbers)}}/{{$numbers}})</h4>
                    @if($typeGame->name == "SLG - 15 Lotofácil" || $typeGame->name == "SLG - 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                      <button wire:click="selecionaTudo()" class="{{ env('AllColor') }}" type="button" onclick="limpacampos();">Seleciona todos os Números</button>
                    @endif

                    <br>
                    
                    <div class="col-md-12 automatic-bet">
                        <p style="font-size: 10px;margin-bottom: auto;">
                            Selecione a quantidade de números para gerar um jogo automático:
                        </p>
                        {{-- puxar do banco de dados quantos numeros pode se jogar --}}
                        @foreach ($busca as $buscas)
                            <button style="margin-top: 1%" wire:click="randomNumbers({{ $buscas['numbers'] }})" class="{{ env('randomNumbersColor') }}" type="button" onclick="limpacampos();">{{ $buscas['numbers'] }}</button>
                        @endforeach 
                    </div>


                <div class="table-responsive responsive-bet">
                    <table class="table text-center">
                        <tbody>
                        @foreach($matriz as $lines)
                            <tr>
                                @foreach($lines as $cols)
                                    <td>
                                        <button wire:click="selectNumber({{$cols}})" id="number_{{$cols}}" type="button"
                                                class="btn {{in_array($cols, $selectedNumbers) ? env('OneNumber2') : 'btn-warning'}} btn-beat-number">{{$cols}}</button>
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

        .table th, .table td {
          border-top: none;
          padding: 5px 5px 5px 5px;
        }

        .ganhos-card h4 {
            font-size: 20px !important;
        }

        @media (max-width: 700px) {
            h4 {
                font-size: 15px;
                margin-left: 7px;
            }
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

