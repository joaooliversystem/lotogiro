@extends('admin.layouts.master')

@section('title', 'Nova Permissão')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.settings.permissions.store')}}" method="POST">
                @csrf
                @method('POST')
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
