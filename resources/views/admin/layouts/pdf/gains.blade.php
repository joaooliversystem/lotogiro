<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{--    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">--}}
    {{--    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@700&display=swap" rel="stylesheet">--}}
    <style type="text/css">

        @page {
            margin: 0cm 0cm;
        }

        .font {
            font-family: 'Exo', serif;
        }

        .text-size-1 {
            font-size: 14px;
        }

        .text-size-2 {
            font-size: 22px;
        }

        .text-size-3 {
            font-size: 30px;
        }

        body {
            margin-top: 1.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 1.5cm;
        }

        .page-break {
            page-break-after: always;
        }

        .bg-danger {
            background-color: red;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-secondary{
            background-color: #BCBCBC;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: #28a745;
        }

        .text-white {
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .border-bottom-dashed {
            border-bottom: 1px dashed;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .py-2 {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .pt-1 {
            padding-top: 5px;
        }


        .px-3 {
            padding-right: 30px;
            padding-left: 30px;
        }

        .m-auto {
            margin: auto;
        }

        .text-bold {
            font-weight: bold;
        }

        .number {
            width: 50px;
            height: 50px;
        }

        .border-radius {
            border-radius: 25px;
        }

        .vertical-middle {
            vertical-align: middle;
        }


    </style>
</head>
<body>
<div class="">
    <div class="border-bottom-dashed">
        <p class="text-danger text-center font text-size-2 text-bold">
            RELATÓRIO DE GANHOS <br/>
            LOTERIABR
        </p>
    </div>
    <div class="border-bottom-dashed text-size-1">
        <p class="">
            <span class="font text-bold">EMITIDO EM:</span>
            <span class="font">{{\Carbon\Carbon::now()->format('d/m/y h:i:s')}}</span>
            <br/>
            <span class="font text-bold">PERÍODO:</span>
            <span class="font">{{\Carbon\Carbon::parse($dateFilter['dateStart'])->format('d/m/Y')}} ATÉ {{\Carbon\Carbon::parse($dateFilter['dateEnd'])->format('d/m/Y')}}</span>
        </p>
    </div>

    <div class="border-bottom-dashed py-2">
        @foreach($collection as $index => $users)
            <div class="text-size-1">
                <p class="">
                    <span class="font text-bold">USUÁRIO:</span>
                    <span class="font">{{$collection[$index][0]['user']['name'] . ' ' . $collection[$index][0]['user']['last_name']}}</span>
                    <br/>
                    <span class="font text-bold">E-MAIL:</span>
                    <span class="font">{{$collection[$index][0]['user']['email']}}</span>
                </p>
            </div>

            <table style="width: 100%">
                <tr class="bg-secondary">
                    <th class="text-left">ID</th>
                    <th class="text-left">CPF CLIENTE</th>
                    <th class="text-left">NOME CLIENTE</th>
                    <th class="text-left">CRIAÇÃO</th>
                    <th class="text-left">STATUS</th>
                    <th class="text-left">VALOR</th>
                    <th class="text-left">%</th>
                    <th class="text-left">COMISSÃO</th>
                </tr>
                @foreach($users as $game)
                    <tr class="border-bottom">
                        <td class="font border-bottom">
                            {{ $game['id'] }}
                        </td>
                        <td class="font border-bottom">
                            {{ \App\Helper\Mask::addMaskCpf($game['client']['cpf']) }}
                        </td>
                        <td class="font border-bottom">
                            {{ $game['client']['name'] }}
                        </td>
                        <td class="font border-bottom">
                            {{ \Carbon\Carbon::parse($game['created_at'])->format('d/m/Y') }}
                        </td>
                        <td class="font border-bottom">
                            @if($game['commission_payment']) Pago @else Aberto @endif
                        </td>
                        <td class="font border-bottom">
                            R${{ \App\Helper\Money::toReal($game['type_game_value']['value']) }}
                        </td>
                        <td class="font border-bottom">
                            {{ $game['commission_percentage'] ?? 0 }}%
                        </td>
                        <td class="font border-bottom">
                            R${{ \App\Helper\Money::toReal($game['commission_value']) }}
                            @php
                                $subtotalCommission +=  $game['commission_value'];
                            @endphp
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-secondary">
                    <th colspan="7" class="text-left">SUBTOTAL</th>
                    <th class="text-left">R${{\App\Helper\Money::toReal($subtotalCommission)}}</th>
                    @php
                        $totalCommission +=  $subtotalCommission;
                    @endphp
                </tr>
            </table>
        @endforeach
            <div class="py-2">
            <table style="width: 100%">
                <tr class="bg-secondary">
                    <th class="text-left">TOTAL</th>
                    <th class="text-left">R${{\App\Helper\Money::toReal($totalCommission)}}</th>
                </tr>
            </table>
            </div>

    </div>


</div>
</body>
</html>
