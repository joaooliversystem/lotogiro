@extends('admin.layouts.master')

@section('title', 'Visualizar Sorteio')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @error('success')
            @push('scripts')
                <script>
                    toastr["success"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            @error('error')
            @push('scripts')
                <script>
                    toastr["error"]("{{ $message }}")
                </script>
            @endpush
            @enderror
        </div>
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Jogo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <td>
                                            Id
                                        </td>
                                        <td>
                                            Tipo de Jogo
                                        </td>
                                        <td>
                                            Concurso
                                        </td>
                                        <td>
                                            Números
                                        </td>
                                        <td>
                                            Data Sorteio
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{$draw->id }}
                                        </td>
                                        <td>
                                            {{$draw->typeGame->name }}
                                        </td>
                                        <td>
                                            {{$draw->competition->number }}
                                        </td>
                                        <td>
                                            {{$draw->numbers }}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($draw->competition->sort_date)->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if(isset($games))
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm" id="result_table">
                                        <thead>
                                        <tr>
                                            <th>Jogo</th>
                                            <th>Pix</th>
                                            <th>Nome</th>
                                            <th>Valor Aposta</th>
                                            <th>Valor Prêmio</th>
                                            <th>Recibo</th>
                                        </tr>
                                        </thead>
                                        @if(isset($games))
                                            <tbody>
                                            @if($games->count() > 0)
                                                @foreach($games as $game)
                                                    <tr>
                                                        <td>{{$game->id}}</td>
                                                        <td>{{$game->client->pix}}</td>
                                                        <td>{{$game->client->name . ' ' . $game->client->last_name}}</td>
                                                        <td>{{\App\Helper\Money::toReal($game->value)}}</td>
                                                        <td>{{\App\Helper\Money::toReal($game->premio)}}</td>
                                                        <td width="180">
                                                            <a href="{{route('admin.bets.games.receipt', ['game' => $game->id, 'format' => 'pdf', 'prize' => true])}}">
                                                                <button class="btn btn-info btn-sm">
                                                                    Gerar Pdf
                                                                </button>
                                                            </a>
                                                            <a href="{{route('admin.bets.games.receipt', ['game' => $game, 'format' => 'txt', 'prize' => true])}}">
                                                                <button type="button" class="btn btn-info btn-sm">
                                                                    Gerar Txt
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="5"> Não houve nenhum ganhador para os números: {{$draw->numbers}}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="{{route('admin.bets.draws.index')}}">
                <button type="button" class="btn btn-block btn-outline-secondary">Voltar a tela principal</button>
            </a>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .btn-beat-number {
            width: 100%;
        }
    </style>
@endpush


@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });
    </script>

@endpush

