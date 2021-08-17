@extends('admin.layouts.master')

@section('title', 'Editar Tipo de Jogo')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.type_games.update', ['type_game' => $typeGame->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.type_game._form')
            </form>
        </section>
    </div>

@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>

@endpush
