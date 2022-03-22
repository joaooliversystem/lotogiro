COMPROVANTE DE APOSTA

GIRO DA SORTE

@if($prize == 1)
PREMIADO

@endif
ID APOSTA: {{$game->id}}

EMITIDO EM: {{\Carbon\Carbon::parse($game->created_at)->format('d/m/Y h:i:s')}}

CPF: {{\App\Helper\Mask::addMaskCpf($game->client->cpf)}}

PARTICIPANTE: {{mb_strtoupper($client->name . ' ' . $client->last_name, 'UTF-8') }}

CONCURSO: {{$game->competition->number }}

DATA SORTEIO: {{\Carbon\Carbon::parse($game->competition->sort_date)->format('d/m/Y')}}

HORA SORTEIO: {{\Carbon\Carbon::parse($game->competition->sort_date)->format('H:i:s')}}

{{mb_strtoupper($typeGame->name, 'UTF-8')}}

@foreach($matriz as $lines)
{{implode(' ', $lines)}}
@endforeach

QTDE DEZENAS: {{$typeGameValue->numbers}}

VALOR APOSTADO: R${{\App\Helper\Money::toReal($game->value)}}

GANHO MÁXIMO: R${{\App\Helper\Money::toReal($game->premio)}}


