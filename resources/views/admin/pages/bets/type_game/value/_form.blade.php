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
                <h3 class="card-title">Tipo de Jogo</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name">Dezenas</label>
                        <input type="text" class="form-control @error('dozens') is-invalid @enderror" id="dozens"
                               name="dozens"
                               maxlength="50" value="{{old('dozens', $value->numbers ?? null)}}">
                        @error('dozens')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="amount">Valor</label>
                        <input type="text" class="form-control @error('amount') is-invalid @enderror"
                               id="amount"
                               name="amount"
                               maxlength="100" value="{{old('amount', isset($value->value) ? \App\Helper\Money::toReal($value->value) : null)}}">
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="prize">Prêmio</label>
                        <input type="text" class="form-control @error('prize') is-invalid @enderror"
                               id="prize"
                               name="prize"
                               maxlength="100" value="{{old('prize', isset($value->value) ? \App\Helper\Money::toReal($value->prize) : null)}}">
                        @error('prize')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.type_games.edit', ['type_game' => $typeGame->id ?? $value->type_game_id])}}">
            <button type="button" class="btn btn-block btn-outline-secondary">Voltar para o tipo de jogo</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(Route::currentRouteName() == 'admin.bets.type_games.values.create') Cadastrar
            Valor  @else  Atualizar Valor @endif </button>
    </div>
</div>

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>


        $(document).ready(function () {
            $('#dozens').inputmask("9999");
            $("#amount").inputmask( 'currency',{"autoUnmask": true,
                radixPoint:",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
            $("#prize").inputmask( 'currency',{"autoUnmask": true,
                radixPoint:",",
                groupSeparator: ".",
                allowMinus: false,
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
        });
    </script>

@endpush
