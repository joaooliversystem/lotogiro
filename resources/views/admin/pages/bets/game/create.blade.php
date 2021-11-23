@extends('admin.layouts.master')

@section('title', 'Novo Jogo')

@section('content')

    <div class="col-md-12">
        <section class="content">
            <form action="{{route('admin.bets.games.store')}}" method="POST" id="form_game">
                @csrf
                @method('POST')
                @include('admin.pages.bets.game._form')
            </form>
        </section>
    </div>
<!-- INICIO MODAL  Editar Evento -->
         <div class="modal fade" id="modal-enviar">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              <h4 class="modal-title">Criar Jogo XML</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
              <form action="{{route('admin.bets.games.store')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
             
              <div class="form-row">
              <div class="form-group col-md-12">
                <label for="client">Cliente</label>
                <select class="custom-select @error('client') is-invalid @enderror" name="client" id="clients" required>
                    <option selected value="">Selecione o Cliente</option>
                    @if(isset($clients) && $clients->count() > 0)
                        @foreach($clients as $client)
                            <option value="{{$client->id}}">{{\App\Helper\Mask::addMaskCpf($client->cpf) .' - '. $client->name.' '. $client->last_name . ' - ' . $client->email . ' - '. \App\Helper\Mask::addMaksPhone($client->ddd.$client->phone)  }}</option>
                        @endforeach
                    @endif
                </select>
              </div>
              </div>
               <div class="row">
              <div class="col-12">
              Arquivo:
              <input class="form-control"  type="file" value="" name="arq" required>
              <input type="hidden" class="form-control" id="type_game" name="type_game" value="{{$typeGame->id}}">
              <input hidden value="1" id="xml" name="xml"> 
              </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-info">Criar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </form>
              </div>
            </div>
             <!--/.modal-content -->
          </div>
           <!--/.modal-dialog -->
        </div>
        <!-- /.modal -->
@endsection


@push('scripts')

    <script>



    </script>

@endpush

