@extends('admin.layouts.master')

@section('title', 'Novo Jogo')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.games.store')}}" method="POST" id="form_game">
                @csrf
                @method('POST')
                @include('admin.pages.bets.game._form')
            </form>
        </section>
    </div>

@endsection

@push('scripts')

    <script>



    </script>

@endpush

