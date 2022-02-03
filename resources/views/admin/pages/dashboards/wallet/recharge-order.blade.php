@extends('admin.layouts.master')

@section('title', 'Saque - Solicitações')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.recharge.orders')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
