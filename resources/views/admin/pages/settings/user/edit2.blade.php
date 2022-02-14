@extends('admin.layouts.master')

@section('title', 'Editar Usuário')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.settings.users.update', ['user' => $user->id])}}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.pages.settings.user._form2')
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
