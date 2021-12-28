@extends('admin.layouts.master')

@section('title', 'Inicio')

@section('content')

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>            

    <div class="row bg-white p-3">
        <div class="col-md-12 p-4">
            <h3 class="text-center">JOGOS</h3>
        </div>

        @if( Auth()->user()->type_client == 1)
          <div class="col-md-7 my-2">
              <div class="form-group">
                  <input type="text" class="form-control" id="link_copy" value="{{route('games.bet', ['user' => auth()->id()])}}">
              </div>
          </div>

          <div class="col-md-2 my-2">
              <button type="button" id="btn_copy_link" class="btn btn-info btn-block">Copiar Link</button>
          </div>

          <div class="col-md-3 my-2">
              <a href="https://api.whatsapp.com/send?text=Segue link para criar um jogo: {{route('games.bet', ['user' => auth()->id()])}}"
                target="_blank">
                  <button type="button" class="btn btn-info btn-block">
                      Enviar via WhatsApp
                  </button>
              </a>
          </div>

        @else

        <h1>testando</h1>

        <div class="card-deck">

          <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
              <h5 class="card-title">Success card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>

          <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
              <h5 class="card-title">Dark card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>

          <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
              <h5 class="card-title">Success card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>

          <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
              <h5 class="card-title">Dark card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>

        </div>
            
        @endif

        @if(\App\Models\TypeGame::count() > 0)
            @foreach(\App\Models\TypeGame::get() as $typeGame)
                <div class="col-md-6 my-2">
                    <a href="{{route('admin.bets.games.create', ['type_game' => $typeGame->id])}}">
                        <button class="btn btn-block text-white"
                                style="background-color: {{$typeGame->color}};">{{$typeGame->name}}</button>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-md-12 p-3 text-center">
                Não existem tipos de jogos cadastrados!
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $('#btn_copy_link').click(function () {
            var link = document.getElementById("link_copy");
            link.select();
            document.execCommand('copy');
        });
    </script>

<script>
    $(document).ready(function(){
      $('.sidenav').sidenav();
    });
  </script>
@endpush



