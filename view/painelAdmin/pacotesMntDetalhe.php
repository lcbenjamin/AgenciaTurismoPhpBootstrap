<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    carrega_pacotes();

    $id = $_GET['id'];
    foreach ($pacotes as $pacote) :
    if($pacote['codPacote']== $id)	{ ?>


<!-- Navegador da Pagina-->
<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Pacotes > Consultar > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-warning" href="./painelAdm.php?adm=pacotesMntAlterar&id=<?php echo $pacote['codPacote'];?>"><i class="fa fa-pencil"></i></i> Editar</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=pacotesMnt"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>
<h3 class="mb-3 text-left"><?php echo $pacote['titulo'] . " - " . caculaDiarias($pacote['dataInicio'],$pacote['dataFim']) . " dias";?></h3>
<div class="row">

    <div class="col-sm-9 text-left">
        
        <table class="table table-hover text-left table-bordered table-striped table-sm">

            <!-- Conteudo -->
            <tbody>
                <tr>		
                    <td class="col-sm-4"><b>Código do Pacote</b></td>
                    <td><?php echo $pacote['codPacote']; ?></td>
                </tr>
                <tr>		
                    <td><b>Titulo</b></td>
                    <td><?php echo $pacote['titulo']; ?></td>
                </tr>
                <tr>		
                    <td><b>Data Inicio</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pacote['dataInicio'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Data fim</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pacote['dataFim'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Diarias</b></td>
                    <td><?php echo caculaDiarias($pacote['dataInicio'],$pacote['dataFim']) ?></td>
                </tr>
                <tr>		
                    <td><b>Origem do pacote [UF/Cidade]</b></td>
                    <td>
                        <?php 
                            echo    carrega_estado_id($pacote['codEstadoOrigem'])['nome'] ." / ".
                                    carrega_cidade_id($pacote['codCidadeOrigem'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Destino do pacote [UF/Cidade]</b></td>
                    <td>
                        <?php 
                            echo    carrega_estado_id($pacote['codEstadoDestino'])['nome'] ." / ".
                                    carrega_cidade_id($pacote['codCidadeDestino'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Descrição</b></td>
                    <td><pre><?php echo $pacote['descricao']; ?></pre></td>
                </tr>
                <tr>		
                    <td><b>Valor Base</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorBase'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Hospedagem/dia</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorHospedagem'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Traslado</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorTraslado'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Passagem Aérea</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorAereo'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Pode parcelar?</b></td>
                    <?php if ($pacote['parcela']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['parcela']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Quantidade de parcelas</b></td>
                    <?php if ($pacote['parcela']=="true") : ?>
                        <td><?php echo $pacote['quantidadeParcelas'] . " vezes"; ?></td>
                    <?php endif; ?>
                    <?php if ($pacote['parcela']=="false") : ?>
                        <td>--</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Hospedagem incluida?</b></td>
                    <?php if ($pacote['hospedagem']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['hospedagem']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Traslado incluido?</b></td>
                    <?php if ($pacote['traslado']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['traslado']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Aéreo incluido?</b></td>
                    <?php if ($pacote['aereo']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['aereo']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Status</b></td>
                    <td><?php echo $pacote['status']; ?></td>
                </tr>
                <tr>		
                    <td><b>Exibe na página incial?</b></td>
                    <?php if ($pacote['evidencia']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['evidencia']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>              
                <tr>		
                    <td><b>Data e hora do Cadastro</b></td>
                    <td><?php echo $pacote['dataHoraCadastro']; ?></td>
                </tr>
                <tr>		
                    <td><b>Passeios</b></td>
                    <td>
                        <ul>
                            <?php 
                                $passeios = carregaPasseiosDoPacote($pacote['codPacote']);
                                foreach ($passeios as $passeio => $titulos) : 
                            ?>
                                <li>
                                    <?php echo $titulos['titulo']; ?>
                                </li>
                            <?php 
                                endforeach;
                             ?>
                        </ul> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
                                
    <div class="row">

        <?php 
            $imagens = carregaImagensDoPacote($pacote['codPacote']);
            foreach ($imagens as $imagem => $nomeImagem) : 
        ?>        
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title=""
                    data-image="../imagens/img_pacotes/<?php echo $nomeImagem['nome']; ?>"
                    data-target="#image-gallery">
                    <img class="img-thumbnail" src="../imagens/img_pacotes/<?php echo $nomeImagem['nome']; ?>">
                </a>
            </div>
                                
        <?php endforeach; ?>       

    </div>

    <!-- Modal de Exibição imagem -->
    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="image-gallery-title"></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                    </button>

                    <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php 
        }
        endforeach;
    ?>

<script>

let modalId = $('#image-gallery');

$(document)
  .ready(function () {

    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current) {
      $('#show-previous-image, #show-next-image')
        .show();
      if (counter_max === counter_current) {
        $('#show-next-image')
          .hide();
      } else if (counter_current === 1) {
        $('#show-previous-image')
          .hide();
      }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr) {
      let current_image,
        selector,
        counter = 0;

      $('#show-next-image, #show-previous-image')
        .click(function () {
          if ($(this)
            .attr('id') === 'show-previous-image') {
            current_image--;
          } else {
            current_image++;
          }

          selector = $('[data-image-id="' + current_image + '"]');
          updateGallery(selector);
        });

      function updateGallery(selector) {
        let $sel = selector;
        current_image = $sel.data('image-id');
        $('#image-gallery-title')
          .text($sel.data('title'));
        $('#image-gallery-image')
          .attr('src', $sel.data('image'));
        disableButtons(counter, $sel.data('image-id'));
      }

      if (setIDs == true) {
        $('[data-image-id]')
          .each(function () {
            counter++;
            $(this)
              .attr('data-image-id', counter);
          });
      }
      $(setClickAttr)
        .on('click', function () {
          updateGallery($(this));
        });
    }
  });

// build key actions
$(document)
  .keydown(function (e) {
    switch (e.which) {
      case 37: // left
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
          $('#show-previous-image')
            .click();
        }
        break;

      case 39: // right
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
          $('#show-next-image')
            .click();
        }
        break;

      default:
        return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
  });
</script>
