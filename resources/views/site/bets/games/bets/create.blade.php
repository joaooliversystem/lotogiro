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
                        @livewire('site.pages.bets.games.bet.create', ['bet' => $bet, 'typeGame' => $typeGame])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
