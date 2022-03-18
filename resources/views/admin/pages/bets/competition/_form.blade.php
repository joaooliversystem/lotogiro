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
        <div class="card card-info">
            <div class="card-header indica-card">
                <h3 class="card-title">Concurso</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror"
                                   id="number" name="number"
                                   maxlength="50" value="{{ old('number', $competition->number ?? null) }}">
                            @error('number')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type_game">Tipo de Jogo</label>
                            <select class="custom-select @error('type_game') is-invalid @enderror" id="type_game"
                                    name="type_game">
                                <option value="">Selecione</option>
                                @if($typeGames->count() > 0)
                                    @foreach($typeGames as $typeGame)
                                        <option value="{{$typeGame->id}}" @if(old('type_game') == $typeGame->id || isset($competition) && $competition->type_game_id == $typeGame->id) selected @endif>{{$typeGame->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('type_game')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sort_date">Data do Sorteio</label>
                            <input type="text" class="form-control @error('sort_date') is-invalid @enderror"
                                   id="sort_date" name="sort_date"
                                   autocomplete="off"
                                   maxlength="50" value="{{ old('sort_date', $competition->sort_date ?? null) }}">
                            @error('sort_date')
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
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.competitions.index')}}">
            <button type="button" class="btn btn-block btn-outline-secondary">Voltar a tela principal</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit"
                class="btn btn-block btn-outline-success">@if(request()->is('admin/bets/competitions/create'))
                Cadastrar Concurso  @else  Atualizar Concurso @endif </button>
    </div>
</div>

@push('scripts')
    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#sort_date').inputmask("99/99/9999 99:99:99");
        });
    </script>
@endpush
