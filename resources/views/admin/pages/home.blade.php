@extends('admin.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12 p-4 faixa-jogos">
            <h3 class="text-center text-bold">JOGOS</h3>
        </div>

        {{-- caso o cliente seja cambista --}}
        @if($User['type_client'] == 1)
            <div class="card-deck" style="width: 100%; margin-bottom: 30px; margin-left: auto;
                margin-right: auto">

                <div class="card text-white bg-success mb-6">
                    <div class="card-body">
                        <h5 class="card-title text-bold">Jogos Feitos</h5> 
                        <i class="nav-icon fas fa-chart-line"  style="float: right; font-size: 50px"></i>
                        <p class="card-text">{{ $JogosFeitos }}</p>
                    </div>
                </div>
                <div class="card text-white bg-danger mb-6" style="">
                    <div class="card-body text-bold">
                        <h5 class="card-title">Saldo</h5> <i class="nav-icon fas fa-chart-line"  style="float: right; font-size: 50px"></i>
                        <p class="card-text">R${{ $saldo }}</p>
                    </div>
                </div>
            </div>
    </div>
        @endif        

        <div class="col-sm-12">
            <div class="card w-100">
                
                <div class="card-header indica-card">
                    Indicações
                </div>
                <div class="container">
                    <div class="row">

                        @if($User['type_client'] != 1)
                        <div class="card-body col-lg-12 col-sm-12">
                            <div class="col-lg-12 my-2 ">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="link_copy" value="{{route('games.bet', ['user' => auth()->id()])}}">
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-lg-6 col-sm-12">
                            <div class="col-lg-12 my-2 alert bg-light indica-corpo" style="float:left;">
                                <button type="button" id="btn_copy_link" class="btn btn-info btn-block">Copiar Link</button>
                                <p class="mensagem">Clique no botão e copie seu link acima</p>
                            </div>
                        </div>  
                        <div class="card-body col-lg-6 col-sm-12">
                            <div class="col-lg-12 my-2 alert bg-light indica-corpo" style="float:right;">
                                <a href="https://api.whatsapp.com/send?text=Segue link para criar um jogo: {{route('games.bet', ['user' => auth()->id()])}}"
                                target="_blank" style="text-decoration: none !important;">
                                    <button type="button" class="btn btn-info btn-block">
                                        Enviar via WhatsApp
                                    </button>
                                    <p class="mensagem">Clique no botão e envie pelo WhatsApp</p>
                                </a>
                            </div> 
                        </div>    
                        @endif
                        <div class="card-body col-lg-6 col-sm-12">
                            <div class="alert bg-light indica-corpo" role="alert">
                                <input id="linkDeIndicacao" style="display:none;" type="text" readonly class="link_copy_link"
                                       value="{{ env('APP_URL') }}/admin/indicate/{{ auth()->user()->id }}"
                                />
                                <button type="button" id="btn_copy_link2" class="btn btn-info btn-block" onclick="CopyMe(getUrl())">Indique e Ganhe!</button>
                                <p class="mensagem">Clique no botão e copie seu link de indicação</p>
                            </div>
                        </div>
                        <div class="card-body col-lg-6 col-sm-12">
                            <div class="indica-corpo bg-light-2" style="color: #fff;" role="alert">
                                <a href="{{ route('admin.settings.users.indicated') }}" class="btn btn-block btn-info">
                                    Seus indicados
                                </a>
                                <p class="mensagem">Clique no botão e veja seus indicados</p>
                            </div>  
                        </div>
                    </div>    
                </div>    
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

        .bg-light-2 {
            background-color: #f8f9fa !important;
        }

        .indica-corpo {
                padding: 35px;
        }

        .mensagem {
          color: #000;
          font-size: 10px;
          text-align: center;
          margin-top: 10px;
        }

        @media screen and (max-width: 600px) {
            .faixa-jogos {
                background: url(https://superlotogiro.com/images/super-lotogiro01.jpg) auto;
                background-position: center;
            }


            .btn {
                padding: 10px;

            }

            .indica-corpo {
                padding: 0px;
            }
        }

    </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $('#btn_copy_link').click(function () {
        var link = document.getElementById("link_copy");
        link.select();
        document.execCommand('copy');
        Swal.fire(
            'Link copiado!',
            '',
            'success'
        );
    });

    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire(
            'Link copiado!',
            '',
            'success'
        );
    };

    function getUrl(){
        return document.getElementById("linkDeIndicacao").value;
    };

    (function () {
        function copy(element) {
            return function () {
                document.execCommand('copy', false, element.select());
            };
        };

        var linkIndicate = document.querySelector('.link_copy_link');
        var copyUrlIndicate = copy(linkIndicate);
        linkIndicate.addEventListener('click', copyUrlIndicate, false);

    }());
</script>
@endpush