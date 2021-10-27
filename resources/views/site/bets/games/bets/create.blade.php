@extends('site.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="container text-center p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Jogo</h3>
                        <div class=" text-right">
                            <a href="{{route('games.bet', ['user' => $bet->user->id, 'bet' => $bet])}}">
                                <button class="btn btn-warning btn-sm">
                                    Voltar
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($bet) && $bet->botao_finalizar == 3) 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">Atenção!</h4>
                                        <p>Não é possível adicionar novos jogos para a aposta pois a mesmo já foi
                                            finalizada:</p>
                                        <hr>
                                        <p class="mb-0">Se desejar criar novos jogos, incie uma nova aposta <a
                                                href="{{route('games.bet', ['user' => $bet->user_id])}}">clicando aqui</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                        @livewire('site.pages.bets.games.bet.create', ['bet' => $bet, 'typeGame' => $typeGame])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
