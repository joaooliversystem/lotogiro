@extends('admin.layouts.master')

@section('title', 'Extrato de Recargas Manuais')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.extract.manual-recharge')
        </div>
    </div>
@endsection

@push('scripts')
@endpush
