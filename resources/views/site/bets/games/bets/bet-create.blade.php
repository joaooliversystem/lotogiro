@extends('site.layouts.master')

@section('title', 'Aposta Cadastrada')

@section('content')
    <div class="container text-center p-0 my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Aposta</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Atenção!</h4>
                            <p>Informe o código abaixo para o vendedor validar sua aposta:</p>
                            <h3>{{$bet->id}}</h3>
                            <hr>
                            <p class="mb-0">Faça seu pagamento referente ao valor da sua aposta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
