@extends('admin.layouts.master')

@section('title', 'Editar Função')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.settings.permissions.update', ['permission' => $permission->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.settings.permission._form')
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
