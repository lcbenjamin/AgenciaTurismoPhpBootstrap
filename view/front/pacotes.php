
<!-- Pacotes nacionais-->
<div class="row" id="tituloPacotes">
    <div class="col-12 text-left my-3">
        <h2 class="display-6 text-dark">
            <i class="fa fa-suitcase mr-2"></i>    
            <u>Pacotes de Viagem</u>
        </h2>
    </div>
</div>
    <div class="row mb-5">
        <?php
        for($i = 0 ; $i < 9 ; $i++){
            echo '
            <div class="col-sm-3">
                <div class="card my-3">
                    <img src="../imagens/diversas/paris.jpg" class="card-img-top">
                    <div class="card-body">
                        <h4 class="card-title">Título 1</h4>
                        <h6 class="card-title mb-2 text-muted">SubTítulo 1</h6>
                        <p class="card-text">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica</p>
                        <div class="card-body text-right">
                            <button type="button" class="btn btn-secondary">Comprar</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        ?>
    </div>