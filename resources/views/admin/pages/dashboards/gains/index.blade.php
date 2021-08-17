@extends('admin.layouts.master')

@section('title', 'Relatório de Ganhos')

@section('content')
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
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.gain.table', ['users' => $users])
        </div>
    </div>
    <div class="modal fade" id="modal_delete_game" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Deseja excluir este Jogo?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Está ação não pode ser revertida
                </div>
                <div class="modal-footer">
                    <form id="destroy" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).on('click', '#btn_delete_game', function () {
            var game = $(this).attr('game');
            var url = '{{ route("admin.bets.games.destroy", ":game") }}';
            url = url.replace(':game', game);
            $("#destroy").attr('action', url);
        });
    </script>

@endpush
