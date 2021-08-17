@extends('admin.layouts.master')

@section('title', 'Editar Usuário')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.clients.update', ['client' => $client->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.client._form')
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
