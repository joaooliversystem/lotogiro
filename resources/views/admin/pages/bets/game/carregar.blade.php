@extends('admin.layouts.master')

@section('title', 'Novo Jogo')

@section('content')
 <form action="{{route('admin.bets.games.store')}}" method="POST" id="form_game">
    @csrf
    @method('POST')
    @include('admin.pages.bets.game._form2')
</form>
        <!-- /.modal -->
@endsection

@push('scripts')
    

@endpush