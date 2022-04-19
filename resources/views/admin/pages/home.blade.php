@extends('admin.layouts.master')

@section('title', 'Inicio')

@section('content')


    <?php

         $user= auth()->user();
        //$user->assignRole('Administrador');
        //$user= auth()->user()->hasAllRoles(Role::all());


    $pontos = 0;

    $query = DB::table('users')
           ->where('email', $user['email'])
           ->get();

    $pontos = $query[0]->pontos;


       ?>

    <?php if($pontos >= 0 and $pontos < 1000):?>

    <div class="alert alert-info" role="alert">
        Iniciante
    </div>

    <?php elseif($pontos >= 1000 and $pontos < 2000):?>

    <div class="alert alert-success" role="alert">
        Junior
    </div>

    <?php elseif($pontos >= 2000 and $pontos < 3000):?>

    <div class="alert alert-success" role="alert">
        Diretor
    </div>

    <?php elseif($pontos >= 3000 and $pontos < 4000):?>

    <div class="alert alert-success" role="alert">
        Diretor Senior
    </div>

    <?php elseif($pontos >= 4000):?>

    <div class="alert alert-success" role="alert">
        Diretor Senior
    </div>

    <?php endif;?>
    <div class="row bg-white p-3">

        <div class="col-md-12 p-4">
            <h3 class="text-center">LINK DE INDICAÇÃO</h3>
        </div>
        <div class="col-md-7 my-2">
            <div class="form-group">
                <input type="text" class="form-control" id="link_indica" value="{{route('games.bet', ['user' => auth()->id()])}}?indica_link=<?php echo $query[0]->id?>">
            </div>
        </div>
        <div class="col-md-2 my-2">
            <button type="button" id="btn_copy_link_indica" class="btn btn-info btn-block">Copiar Link</button>
        </div>
        <div class="col-md-3 my-2">
            <a href="https://api.whatsapp.com/send?text=Segue link para criar um jogo: {{route('games.bet', ['user' => auth()->id()])}}?indica_link=<?php echo $query[0]->id?>"
               target="_blank">
                <button type="button" class="btn btn-info btn-block">
                    Enviar via WhatsApp
                </button>
            </a>
        </div>


        <div class="col-md-12 p-4">
            <h3 class="text-center">JOGOS</h3>
        </div>
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

        @if(\App\Models\TypeGame::count() > 0)
            @foreach(\App\Models\TypeGame::get() as $typeGame)
                <div class="col-md-6 my-2">
                    <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame->id])}}">
                        <button class="btn btn-block text-white"
                                style="background-color: {{$typeGame->color}};">{{$typeGame->name}}</button>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-md-12 p-3 text-center">
                Não existem tipos de jogos cadastrados!
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $('#btn_copy_link').click(function () {
            var link = document.getElementById("link_copy");
            link.select();
            document.execCommand('copy');
        });
    </script>
@endpush



