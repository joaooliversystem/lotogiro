@extends('admin.layouts.master')

@section('title', 'Usuários Indicados por você - Nível: ')

@section('content')
    <div class="row bg-white p-3">
        @livewire('pages.dashboards.user.indicated-by-level')
    </div>
@endsection

@push('styles')
    <style>
        .src-image {
            display: none;
        }
        .card {
            overflow: hidden;
            position: relative;
            border: 1px solid #CCC;
            border-radius: 8px;
            text-align: center;
            padding: 0;
            background-color: #284c79;
            color: rgba(255,255,255,1);
        }
        .card .header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1;
        }
        .card .avatar {
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            justify-items: center;
            position: relative;
            margin-top: 15px;
            z-index: 100;
        }
        .card .avatar i {
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            justify-items: center;
            width: 100px;
            height: 100px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,1);
        }
        .card .avatar img {
            width: 100px;
            height: 100px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            border: 5px solid rgba(0,0,30,0.8);
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).on('click', '#btn_delete_user', function () {
            var user = $(this).attr('user');
            var url = '{{ route("admin.settings.users.destroy", ":user") }}';
            url = url.replace(':user', user);
            $("#destroy").attr('action', url);
        });

        $(document).ready(function () {
            var table = $('#user_table').DataTable({
                language: {
                    url: '{{asset('admin/layouts/plugins/datatables-bs4/language/pt_Br.json')}}'
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.settings.users.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
