@extends('admin.layouts.master')

@section('title', 'Saque - Solicitações')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.withdraw.admin-list')
        </div>
    </div>
@endsection

@push('scripts')

@endpush
