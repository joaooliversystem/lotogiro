@extends('admin.layouts.master')

@section('title', 'Nova Função')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.settings.roles.store')}}" method="POST">
                @csrf
                @method('POST')
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
