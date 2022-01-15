@extends('admin.layouts.master')

@section('title', 'Carteira - Extrato de transações')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.extract.table')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
