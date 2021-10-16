<div>
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
        </tbody>
    </table>
    <div class="form-row">
        <div class="form-group col-md-12">
            <div wire:ignore>
                <label for="client">Cliente</label>
                <select class="custom-select @error('client') is-invalid @enderror" name="client" id="clients">
                    <option selected value="">Selecione o Cliente</option>
                    @if(isset($clients) && $clients->count() > 0)
                        @foreach($clients as $client)
                            <option value="{{$client->id}}">{{\App\Helper\Mask::addMaskCpf($client->cpf) .' - '. $client->name.' '. $client->last_name . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)  }}</option>
                        @endforeach
                    @endif
                </select>
                @error('client')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            <input type="hidden" name="numbers" value="{{implode(',', $selectedNumbers) ?? null}}">
        </div>
        <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
                @if(isset($values) && $values->count() > 0)
                    @foreach($values as $value)
                    <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                    <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                    <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
                    Digite o Valor da Aposta
                    <input type="text" id="value" onchange="altera();" value="" name="value" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                    Valor do Prêmio R$
                    <input type="text" id="premio" value="" name="premio" disabled>
                    <button  class="btn btn-success" type="button">Calcular</button>
                    @endforeach
                @else
                
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
                    <table class="table  text-center">
                        <tbody>
                        @foreach($matriz as $lines)
                            <tr>
                                @foreach($lines as $cols)
                                    <td>
                                        <button wire:click="selectNumber({{$cols}})" id="number_{{$cols}}" type="button"
                                                class="btn btn-success {{in_array($cols, $selectedNumbers) ? 'btn-success' : 'btn-warning'}} btn-beat-number">{{$cols}}</button>
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
    <script>

        $(document).ready(function () {
            $('#clients').select2({
                theme: "bootstrap"
            });
            $('#sort_date').inputmask("99/99/9999 99:99:99");
        });
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

@endpush

