@extends('admin.layouts.master')

@section('title', 'Editar Função')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.settings.roles.update', ['role' => $role->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.settings.role._form')
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
