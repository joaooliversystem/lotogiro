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
                <h3 class="card-title">Aposta</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Cliente</h4>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <td>
                                        Cpf
                                    </td>
                                    <td>
                                        Nome
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        {{\App\Helper\Mask::addMaskCpf($validate_game->client->cpf)}}
                                    </td>
                                    <td>
                                        {{$validate_game->client->name}} {{$validate_game->client->last_name}}
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Jogos</h4>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Tipo de Jogo</th>
                                    <th scope="col">Concurso</th>
                                    <th scope="col">Dezenas</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Prêmio</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($totalValue = 0)
                                @php($totalPrize = 0)
                                @forelse($validate_game->games as $game)
                                    <tr>
                                        <td>{{$game->typeGame->name}}</td>
                                        <td>{{$game->competition->number}}</td>
                                        <td>{{$game->numbers}}</td>
                                        <td>
                                            R${{\App\Helper\Money::toReal($game->typeGameValue->value)}}</td>
                                        <td>
                                            R${{\App\Helper\Money::toReal($game->typeGameValue->prize)}}</td>
                                    </tr>
                                    @php($totalValue += $game->typeGameValue->value)
                                    @php($totalPrize += $game->typeGameValue->prize)
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4">Não existem jogos criados para essa aposta!</td>
                                    </tr>
                                </tbody>
                                @endforelse
                                <tfoot>
                                <tr>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col">R${{\App\Helper\Money::toReal($totalValue)}}</th>
                                    <input type="text" hidden name="valor" value="{{$totalValue}}">
                                    <th scope="col">R${{\App\Helper\Money::toReal($totalPrize)}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.validate-games.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">Voltar a tela principal</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit" id="button_game" class="btn btn-block btn-outline-success">Validar</button>
    </div>
</div>

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

