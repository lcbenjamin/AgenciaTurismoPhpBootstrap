<!-- Modal de exclusão de Pacote-->
<div class="modal fade" id="delete-modal-item-carrinho" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Excluir Pedido</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p>Deseja realmente excluir o pedido do carrinho?</p>
       </div>
       <div class="modal-footer">
        <a id="cancela" class="btn btn-danger text-light" data-dismiss="modal">N&atilde;o</a>
        <a id="confirmaExcPacoteCarrinho" class="btn btn-success" href="#">Sim</a>        
       </div>
     </div>
   </div>
 </div>

<!-- Modal de confirmação de compra-->
<div class="modal fade" id="confirma-modal-item-carrinho" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Finalizar Pedido</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p>Deseja realmente comprar os itens do carrinho?</p>
       </div>
       <div class="modal-footer">
        <a id="cancela" class="btn btn-danger text-light" data-dismiss="modal">N&atilde;o</a>
        <a id="confirmaExcPacoteCarrinho" class="btn btn-success" href="index.php?p=carrinho&confirma=ok#tituloCarrinho">Sim</a>
       </div>
     </div>
   </div>
 </div>
