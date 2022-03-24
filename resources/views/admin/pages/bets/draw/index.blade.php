@extends('admin.layouts.master')

@section('title', 'Sorteios')

@section('content')
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
            @can('create_draw')
                <a href="{{route('admin.bets.draws.create')}}">
                    <button class="btn btn-info my-2">Novo Sorteio</button>
                </a>

                <label class="dropdown">
                    <div class="dd-button">
                        Enviar relatório diário
                    </div>
                    <input type="checkbox" class="dd-input" id="test">

                    <ul class="dd-menu">
                        <li><a class="link-muted" href="{{ route('admin.bets.report-draws', 'geral') }}">Geral</a></li>
                        <li><a class="link-muted" href="{{ route('admin.bets.report-draws', 'financeiro')
                        }}">Financeiro</a></li>
                    </ul>
                </label>
            @endcan
            <div class="table-responsive extractable-cel">
                <table class="table table-striped table-hover table-sm" id="draw_table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo de Jogo</th>
                        <th>Concurso</th>
                        <th>Criação</th>
                        <th style="width: 80px">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_draw" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Deseja excluir este sorteio?</h5>
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

@push('styles')
    <style>

        /* Dropdown */

        .dropdown {
            display: inline-block;
            position: relative;
        }

        .dd-button {
            display: inline-block;
            border: 1px solid gray;
            border-radius: 4px;
            padding: 7px 30px 7px 20px;
            background-color: #ffffff;
            cursor: pointer;
            white-space: nowrap;
        }

        .dd-button:after {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid black;
        }

        .dd-button:hover {
            background-color: #eeeeee;
        }


        .dd-input {
            display: none;
        }

        .dd-menu {
            position: absolute;
            top: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0;
            margin: 2px 0 0 0;
            box-shadow: 0 0 6px 0 rgba(0,0,0,0.1);
            background-color: #ffffff;
            list-style-type: none;
            z-index: 999;
        }

        .dd-input + .dd-menu {
            display: none;
        }

        .dd-input:checked + .dd-menu {
            display: block;
        }

        .dd-menu li {
            padding: 10px 20px;
            cursor: pointer;
            white-space: nowrap;
        }

        .dd-menu li:hover {
            background-color: #f6f6f6;
        }

        .dd-menu li a {
            display: block;
            margin: -10px -20px;
            padding: 10px 20px;
        }

        .dd-menu li.divider{
            padding: 0;
            border-bottom: 1px solid #cccccc;
        }
    </style>
@endpush

@push('scripts')

    <script type="text/javascript">

        $(document).on('click', '#btn_delete_draw', function () {
            var draw = $(this).attr('draw');
            var url = '{{ route("admin.bets.draws.destroy", ":draw") }}';
            url = url.replace(':draw', draw);
            $("#destroy").attr('action', url);
        });

        $(document).ready(function () {
            var table = $('#draw_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bets.draws.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'type_game', name: 'type_game'},
                    {data: 'competition', name: 'competition'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endpush
