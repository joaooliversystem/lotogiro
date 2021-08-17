@extends('admin.layouts.master')

@section('title', 'Novo Sorteio')

@section('content')

    <div class="col-md-12">
        <section class="content">
            @livewire('pages.bets.draw.form', ['typeGames' => $typeGames ?? null])
        </section>
    </div>

@endsection

