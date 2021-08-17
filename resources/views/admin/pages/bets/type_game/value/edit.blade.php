@extends('admin.layouts.master')

@section('title', 'Editar Usuário')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.type_games.values.update', ['type_game' => $value->type_game_id, 'value' => $value->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.type_game.value._form')
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
