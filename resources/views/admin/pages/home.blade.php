@extends('admin.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12 p-4">
            <h3 class="text-center">JOGOS</h3>
        </div>

        {{-- caso o cliente seja cambista --}}
        @if($User['type_client'] == 1)

        <div class="card-deck" style="width: 100%; margin-bottom: 30px; margin-left: auto;
        margin-right: auto">

            <div class="card text-white bg-success mb-6" style="">
              <div class="card-header">Jogos Feitos</div>
              <div class="card-body">
                <h5 class="card-title">Jogos Feitos</h5> <i class="nav-icon fas fa-chart-line"  style="float: right; font-size: 50px"></i>
                <p class="card-text">{{ $JogosFeitos }}</p>
              </div>
            </div>

            <div class="card text-white bg-danger mb-6" style="">
              <div class="card-header">Saldo</div>
              <div class="card-body">
                <h5 class="card-title">Saldo</h5> <i class="nav-icon fas fa-chart-line"  style="float: right; font-size: 50px"></i>
                <p class="card-text">R${{ $saldo }}</p>
              </div>
            </div>

          </div>
    </div>
    <div class="row bg-white p-3">
        @else

            <div class="col-md-7 my-2">
                <div class="form-group">
                    <input type="text" class="form-control" id="link_copy" value="{{route('games.bet', ['user' => auth()->id()])}}">
                </div>
            </div>
            <div class="col-md-2 my-2">
                <button type="button" id="btn_copy_link" class="btn btn-info btn-block">Copiar Link</button>
            </div>
            <div class="col-md-3 my-2">
                <a href="https://api.whatsapp.com/send?text=Segue link para criar um jogo: {{route('games.bet', ['user' => auth()->id()])}}"
                target="_blank">
                    <button type="button" class="btn btn-info btn-block">
                        Enviar via WhatsApp
                    </button>
                </a>
            </div>
    </div>
        @endif

        <div class="row bg-white p-3">
            <div class="card w-100">
                <div class="card-header bg-blue">
                    Seu link de indicação
                </div>
                <div class="card-body">
                    <div class="alert bg-light" role="alert">
                        <input type="text" readonly class="link_copy_link"
                               value="{{ env('APP_URL') }}/{{ auth()->user()->link }}"
                        />
                    </div>
                </div>
                <div class="card-header">
                    <a href="{{ route('admin.settings.users.indicated') }}" class="btn btn-block btn-outline-primary">
                        Seus indicados
                    </a>
                </div>
            </div>
        </div>

        @if(\App\Models\TypeGame::count() > 0)
            <div class="row">
            @foreach(\App\Models\TypeGame::get() as $typeGame)
                <div class="col-md-6 my-2">
                    <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame->id])}}">
                        <button class="btn btn-block text-white"
                                style="background-color: {{$typeGame->color}};">{{$typeGame->name}}</button>
                    </a>
                </div>
            @endforeach
            </div>
        @else
            <div class="col-md-12 p-3 text-center">
                Não existem tipos de jogos cadastrados!
            </div>
        @endif
    </div>

@endsection

@push('styles')
    <style>
        *:focus{
            outline:none;
        }
        .link_copy_link{
            width: 100%;
            padding: .5em 0 .5em 0;
            border: 1px solid #007bff;
            font-size: 24px;
            text-align: center;
        }
        .link_copy_link:active, .link_copy_link:focus, .link_copy_link:focus-visible{
            border: 1px solid #00c054 !important;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $('#btn_copy_link').click(function () {
            var link = document.getElementById("link_copy");
            link.select();
            document.execCommand('copy');
        });

        (function() {
            function copy(element) {
                return function() {
                    document.execCommand('copy', false, element.select());
                }
            }

            var linkIndicate = document.querySelector('.link_copy_link');
            var copyUrlIndicate = copy(linkIndicate);
            linkIndicate.addEventListener('click', copyUrlIndicate, false);
        }());
    </script>
@endpush
