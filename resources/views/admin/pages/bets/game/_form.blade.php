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
                @livewire('pages.bets.game.form', ['typeGame' => $typeGame ?? null , 'clients' => $clients ?? null, 'game' => $game ?? null])
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{route('admin.bets.games.index', ['type_game' => $typeGame->id])}}">
            <button type="button" class="btn btn-block btn-info">Voltar a tela principal</button>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <button type="submit" id="button_game" onclick="mudarListaNumerosGeral()"
                class="btn btn-block btn-success">@if(request()->is('admin/bets/games/create/'.$typeGame->id)) 
                Cadastrar Jogo  
                @else  
                Atualizar Jogo 
                @endif 
            </button>
    </div>
</div>


@push('scripts')

    <script src="{{asset('admin/layouts/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script>
        var formID = document.getElementById("form_game");
        var send = $("#button_game");

        $(formID).submit(function(event){
            if (formID.checkValidity()) {
                send.attr('disabled', 'disabled');
            }
        });

        $(document).ready(function () {
            $('#cpf').inputmask("999.999.999-99");
            $('#phone').inputmask("(99) 9999[9]-9999");
        });
    </script>

@endpush

