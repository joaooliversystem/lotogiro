@extends('site.layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="container p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Apostas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(isset($hashGame) && empty($hashGame->client_id))
                            <div class="row">
                                <div class="col-md-12">
                                    @livewire('site.pages.bets.games.hash.client', ['hashGame' => $hashGame, 'typeGames'
                                    =>
                                    $typeGames])
                                </div>
                            </div>
                        @else
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Cpf</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Pix</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$hashGame->client->cpf}}</td>
                                            <td>{{$hashGame->client->name}} {{$hashGame->client->last_name}}</td>
                                            <td>{{$hashGame->client->pix}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form action="{{route('games.hash.create', ['hash' => $hashGame->hash])}}"
                                  method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="type_game">Tipo de Jogo</label>
                                        <select class="custom-select @error('type_game') is-invalid @enderror"
                                                id="type_game" name="type_game">
                                            <option value="" selected>Selecione</option>
                                            @forelse($typeGames as $typeGame)
                                                <option value="{{$typeGame->id}}">{{$typeGame->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('type_game')
                                        <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-md-12">
                                        <button class="btn btn-success btn-block">
                                            Adicionar Novo Jogo
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Tipo de Jogo</th>
                                        <th scope="col">Dezenas</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Prêmio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($totalValue = 0)
                                    @php($totalPrize = 0)
                                    @forelse($hashGame->games as $game)
                                        <tr>
                                            <td>{{$game->typeGame->name}}</td>
                                            <td>{{$game->numbers}}</td>
                                            <td>R${{\App\Helper\Money::toReal($game->typeGameValue->value)}}</td>
                                            <td>R${{\App\Helper\Money::toReal($game->typeGameValue->prize)}}</td>
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
                                        <th scope="col">R${{\App\Helper\Money::toReal($totalValue)}}</th>
                                        <th scope="col">R${{\App\Helper\Money::toReal($totalPrize)}}</th>
                                    </tr>
                                    </tfoot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
