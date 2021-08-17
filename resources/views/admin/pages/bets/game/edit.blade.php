@extends('admin.layouts.master')

@section('title', 'Editar Usuário')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.games.update', ['game' => $game->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.game._read')
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
