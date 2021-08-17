@extends('admin.layouts.master')

@section('title', 'Editar Concurso')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.competitions.update', ['competition' => $competition->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.bets.competition._form')
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
