<div>
    <div class="modal fade text-center py-5"  id="offerModal"
         tabindex="1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="top-strip"></div>
                    <div class="h2">
                        <img class="img-circle img-fluid" src="http://lotogiro.pc/admin/images/painel/Trevo.png"
                             alt="" style="max-height: 15vh;">
                    </div>
                    <h2 class="pb-1 text-muted">Sem Saldo? Que tal fazer uma recarga agora?</h2>

                    <div class="row">
                        <div class="col-sm-6">
                            <button wire:click="closeModal(0)" data-dismiss="modal" class="btn btn-warning btn-block
                                text-bold pointer-event closeOffer">Não quero jogar ainda.</button>
                        </div>
                        <div class="col-sm-6">
                            <button wire:click="closeModal(1)" data-dismiss="modal" class="btn btn-primary btn-block
                                text-bold closeOffer">Vamos lá!</button>
                        </div>
                    </div>
                    <div class="bottom-strip"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#offerModal').modal('show');
</script>
