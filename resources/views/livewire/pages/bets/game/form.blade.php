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
            @endif
            <td> <button data-toggle="modal" data-target="#modal-enviar" class="btn btn-primary" type="button">Carregar </button></td>
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
            <ul class="list-group list-group-horizontal-sm">
                @if(isset($values) && $values->count() > 0)
                    @foreach($values as $value)
                        <li class="list-group-item">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="value_{{$value->id}}" value="{{$value->id}}" name="value"
                                       class="custom-control-input @error('value') is-invalid @enderror">
                                <label class="custom-control-label" for="value_{{$value->id}}">
                                    Valor da Aposta: R${{\App\Helper\Money::toReal($value->value)}}<br/>
                                    Valor do Prêmio: R${{\App\Helper\Money::toReal($value->prize)}}
                                </label>
                                @error('value')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
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
                    @if($typeGame->name == "Lotogiro - 15 Lotofácil" || $typeGame->name == "Lotogiro 20 LotoMania" || $typeGame->name == "ACUMULADO 15 lotofacil")
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

    </script>

@endpush

