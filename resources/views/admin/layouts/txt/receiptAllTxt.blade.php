COMPROVANTE DE APOSTA
{{ env("nome_sistema") }}
@if($prize == 1)
PREMIADO
@endif
@foreach ($jogosCliente as $jogos)
ID APOSTA: {{$jogos['id']}}
EMITIDO EM: {{\Carbon\Carbon::parse($jogos->created_at)->format('d/m/Y h:i:s')}}
PARTICIPANTE: {{ $Nome }}
TELEFONE: {{ $telefone }}
CONCURSO: {{ $jogos->competition->number }}
DATA SORTEIO: {{\Carbon\Carbon::parse($Datas['sort_date'])->format('d/m/Y')}}
HORA SORTEIO: {{\Carbon\Carbon::parse($Datas['sort_date'])->format('H:i:s')}}
{{mb_strtoupper($jogos->typeGame->name, 'UTF-8')}}
@php
$numbers = array();
                $numbers = explode(',', $jogos['numbers']);
                asort($numbers, SORT_NUMERIC);

                $matriz = [];
                $line = [];
                $index = 0;
                $count = 0;

                foreach ($numbers as $number) {
                    if ($count < 10) {
                        $count++;
                    } else {
                        $index++;
                        $count = 1;
                        $line = [];
                    }
                    array_push($line, $number);

                    $matriz[$index] = $line;
                }

@endphp
@foreach($matriz as $lines)
{{implode(' ', $lines)}}
@endforeach
    @php
        $contDezenas = array();
        $contDezenas = explode(',', $jogos['numbers']);
    @endphp
QTDE DEZENAS: {{ count($contDezenas) }}
VALOR APOSTADO: R${{\App\Helper\Money::toReal($jogos{'value'})}}
GANHO MÁXIMO: R${{\App\Helper\Money::toReal($jogos['premio'])}}
------------------

@endforeach

