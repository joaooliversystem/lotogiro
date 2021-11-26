@extends('admin.layouts.master')

@section('title', 'Extrato de Saldo')

@section('content')
    <style>
        ul.pagination{
            float:right !important;
        }
    </style>
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @error('success')
            @push('scripts')
                <script>
                    toastr["success"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            @error('error')
            @push('scripts')
                <script>
                    toastr["error"]("{{ $message }}")
                </script>
            @endpush
            @enderror
            {{-- TODO: Verificar permissões para acessar rota e recurso --}}
            <div class="table-responsive">
                <h4 class="my-4">Extrato de Saldo | {{ $user->name }} - Saldo Total: {{ \App\Helper\Money::toReal($user->balance) }}</h4>
                <table class="table table-striped table-hover table-bordered table-lg" id="statementBalance_table">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Responsável</th>
                        <th>Valor</th>
                        <th>Valor Anterior</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($historybalance as $history)
                        <tr>
                            <td>{{ $history->data }}</td>
                            <td>{{ $history->responsavel }}</td>
                            <td>{{ $history->value }}</td>
                            <td>{{ $history->old_value }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum dado para exibir.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">
                            {!! $historybalance->links('pagination::bootstrap-4') !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
