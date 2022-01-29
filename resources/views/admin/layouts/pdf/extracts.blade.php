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

        .bg-secondary {
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
            RELATÓRIO DE EXTRATO <br/>
            LOTERIABR
        </p>
    </div>
    <div class="border-bottom-dashed text-size-1">
        <p class="">
            <span class="font text-bold">EMITIDO EM:</span>
            <span class="font">{{\Carbon\Carbon::now()->format('d/m/y h:i:s')}}</span>
            <br/>
            <span class="font text-bold">PERÍODO:</span>
            <span
                class="font">{{\Carbon\Carbon::parse($dateFilter['dateStart'])->format('d/m/Y')}} ATÉ {{\Carbon\Carbon::parse($dateFilter['dateEnd'])->format('d/m/Y')}}</span>
        </p>
    </div>

    <div class="border-bottom-dashed py-2">
        <table style="width: 100%">
            <tr class="bg-secondary">
                <th class="text-left">ID</th>
                <th class="text-left">TIPO</th>
                <th class="text-left">DESCRIÇÃO</th>
                <th class="text-left">USUÁRIO</th>
                <th class="text-left">CLIENTE</th>
                <th class="text-left">CRIAÇÃO</th>
                <th class="text-left">VALOR</th>
            </tr>
            @php
                $credit = 0;
                $debit = 0;
            @endphp
            @foreach($extracts as $extract)
                <tr class="border-bottom">
                    <td class="font border-bottom">
                        {{ $extract['id'] }}
                    </td>
                    <td class="font border-bottom">
                        @if($extract['type'] == 1)
                            <span class="text-success">Crédito</span>
                        @elseif($extract['type'] ==2)
                            <span class="text-danger">Débito</span>
                        @endif
                    </td>
                    <td class="font border-bottom">
                        {{ $extract['description'] }}
                    </td>
                    <td class="font border-bottom">
                        {{ !empty($extract['user']['name']) ? $extract['user']['name'] .' '. $extract['user']['last_name']: null }}
                    </td>
                    <td class="font border-bottom">
                        {{ !empty($extract['client']['name']) ? $extract['client']['name'] .' '. $extract['client']['last_name']: null }}
                    </td>
                    <td class="font border-bottom">
                        {{ \Carbon\Carbon::parse($extract['created_at'])->format('d/m/Y') }}
                    </td>
                    <td class="font border-bottom">
                        R${{ \App\Helper\Money::toReal($extract['value']) }}
                        @php
                            if($extract['type'] == 1){
                                $credit += $extract['value'];
                            }elseif($extract['type'] == 2){
                                $debit += $extract['value'];
                            }
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr class="bg-secondary">
                <th colspan="6" class="text-left">TOTAL</th>
                <th class="text-left">R${{\App\Helper\Money::toReal($credit - $debit)}}</th>
            </tr>
        </table>

    </div>


</div>
</body>
</html>
