@extends('admin.layouts.master')

@section('title', 'Editar Usuário')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.validate-games.update', ['validate_game' => $validate_game->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.validate_games._read')
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
