@extends('admin.layouts.master')

@section('title', 'Novo Cliente')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.clients.store')}}" method="POST">
                @csrf
                @method('POST')
                @include('admin.pages.bets.client._form')
            </form>
        </section>
    </div>

@endsection

