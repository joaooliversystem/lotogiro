@extends('admin.layouts.master')

@section('title', 'Detalhe do Pedido')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.recharge.order-detail')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
