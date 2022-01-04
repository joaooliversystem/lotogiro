<div class="row">
    <div class="col-md-12">
        @if(isset($matriz))
            <h4>Selecione os números:({{count($selectedNumbers)}}/{{$numbers}})</h4>
            @if($typeGame->name == "Lotogiro - 15 Lotofácil" || $typeGame->name == "Lotogiro 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X Lotofácil" || $typeGame->name == "ACUMULADO 15 lotofacil")
                <button wire:click="selecionaTudo()" class="btn btn-success" type="button" onclick="limpacampos();">Seleciona todos os Números</button>

            @endif

            {{-- puxar do banco de dados quantos numeros pode se jogar --}}
            @foreach ($busca as $buscas)
                <button wire:click="randomNumbers({{ $buscas['numbers'] }})" class="btn btn-success" type="button">{{ $buscas['numbers'] }}</button>
            @endforeach

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
