<div>
    <div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="name">Nome</label>
                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                       name="name"
                       maxlength="50" value="{{old('name', $typeGame->name ?? null)}}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="numbers">Quantidade de números</label>
                <input wire:model="numbers" type="text" class="form-control @error('numbers') is-invalid @enderror"
                       id="numbers"
                       name="numbers"
                       maxlength="100" value="{{old('numbers', $typeGame->numbers ?? null)}}">
                @error('numbers')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="columns">Números por coluna</label>
                <input wire:model="columns" type="text" class="form-control @error('columns') is-invalid @enderror"
                       id="columns"
                       name="columns"
                       maxlength="100" value="{{old('columns', $typeGame->columns ?? null)}}">
                @error('columns')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <div wire:ignore>
                    <label for="columns">Cor</label>
                    <input wire:model="color" type="text" class="form-control @error('color') is-invalid @enderror"
                           id="color"
                           name="color"
                           maxlength="100" value="{{old('color', $typeGame->color ?? null)}}" autocomplete="off">
                    @error('color')
                    <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="description">Descrição</label>
                <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"  id="description"
                          name="description" maxlength="200">{{old('description', $typeGame->description ?? null)}}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
        </div>
        @if(Route::currentRouteName() == 'admin.bets.type_games.edit')
            <div class="row my-2">
                <div class="col-md-12">
                    <a href="{{route('admin.bets.type_games.values.create', ['type_game' => $typeGameId ?? null])}}">
                        <button type="button" class="btn text-white btn-info mb-3">Adicionar Valor
                        </button>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="type_game_values_table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Dezenas</th>
                            <th>Multiplicador</th>
                            <th>Máximo em Reais</th>
                            <th>Criação</th>
                            <th style="width: 80px">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                @if(isset($matriz))
                    <h3>Exemplo:</h3>
                    <div class="table-responsive">
                        <table class="table  text-center">
                            <tbody>
                            @foreach($matriz as $lines)
                                <tr>
                                    @foreach($lines as $cols)
                                        <td>
                                            <button type="button"
                                                    class="btn btn-warning btn-beat-number">{{$cols}}</button>
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

</div>


@push('styles')
    <link rel="stylesheet"
          href="{{asset('admin/layouts/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <style>
        .btn-beat-number {
            width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(Route::currentRouteName() == 'admin.bets.type_games.edit')
            $(document).on('click', '#btn_delete_type_game_value', function () {
                var type_game_value = $(this).attr('type_game_value');
                var type_game = $(this).attr('type_game');
                var url = '{{ route("admin.bets.type_games.values.destroy", ['type_game' => ":type_game", 'value' => ":type_game_value"]) }}';
                url = url.replace(':type_game_value', type_game_value);
                url = url.replace(':type_game', type_game);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: 'DELETE',
                    success: function (result) {
                        window.location.reload();
                    }
                });
            });

            var table = $('#type_game_values_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.type_games.values.index', ['type_game' => $typeGameId]) }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'numbers', name: 'numbers'},
                    {data: 'multiplicador', name: 'multiplicador'},
                    {data: 'maxreais', name: 'maxreais'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            @endif

            $('#color').colorpicker();
            $('#dozens').inputmask("99999");
            $("#amount").inputmask('currency', {
                "autoUnmask": true,
                radixPoint: ",",
                groupSeparator: ".",
                allowMinus: false,
                prefix: 'R$ ',
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });

        });
    </script>

    <script src="//unpkg.com/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('admin/layouts/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
@endpush
