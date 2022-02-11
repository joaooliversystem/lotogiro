<div>
    <form wire:submit.prevent="submit" class="text-left">
        <div class="form-row">
            {{-- <div class="form-group col-md-2">
                <label for="name">Cpf</label>
                <input wire:model.lazy="cpf" type="text"
                       class="form-control @error('cpf') is-invalid @enderror"
                       id="cpf"
                       name="cpf"
                       maxlength="50" value="{{old('cpf', $client->name ?? null)}}">
                <small>Apenas Números</small>
                @error('cpf')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div> --}}

            <div class="form-group col-md-3">
                <label for="phone">Telefone</label>
                <input wire:model.lazy="phone" type="text"
                       class="form-control @error('phone') is-invalid @enderror" id="phone"
                       name="phone"
                       maxlength="100"
                       value="{{old('phone', isset($client->phone) && !empty($client->phone) ? $client->ddd.$client->phone : null) }}">
                <small>Apenas Números</small>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="name">Nome</label>
                <input wire:model="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" id="name"
                       name="name"
                       maxlength="50" value="{{old('name', $client->name ?? null)}}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="last_name">Sobrenome</label>
                <input wire:model="last_name" type="text"
                       class="form-control @error('last_name') is-invalid @enderror"
                       id="last_name"
                       name="last_name"
                       maxlength="100"
                       value="{{old('last_name', $client->last_name ?? null)}}">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="pix">Pix</label>
                <input wire:model="pix" type="text"
                       class="form-control @error('pix') is-invalid @enderror" id="pix"
                       name="pix"
                       maxlength="50" value="{{old('pix', $client->pix ?? null)}}">
                @error('pix')
                <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                @enderror
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <button class="btn btn-success btn-block">
                    Incluir Cliente na Aposta
                </button>
            </div>
        </div>
    </form>
</div>
