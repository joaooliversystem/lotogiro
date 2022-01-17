@extends('admin.layouts.master')

@section('title', 'Carteira - Transferência')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.transfer.table')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
