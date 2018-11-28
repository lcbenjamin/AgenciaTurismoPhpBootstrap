/**
 * Passa os dados do usuario para o Modal, e atualiza o link para exclusão
 */

$('#delete-modal-usuario').on('show.bs.modal', function (event) {
  
    var button = $(event.relatedTarget);
    var id = button.data('usuario');
    
    var modal = $(this);
    modal.find('.modal-title').text('Excluir Usuario #' + id);
    modal.find('#confirma').setAttribute('href', 'delete.php?id=' + id);
  })

  
/**
 * Script para tratar campos input DATA
 */

$('.dataFormatada').datepicker({
    format: 'dd/mm/yyyy',
    language: "pt-BR",
    autoclose: true
    
});



/**
 * Script para inclusão da foto do perfil
 */

$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
            $('.image-preview').popover('show');
        }, 
        function () {
            $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Visualizar</strong>"+$(closebtn)[0].outerHTML,
        content: "Nenhuma Imagem Selecionada",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Procurar"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Alterar");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});

// Tratamento do input file na Tela PACOTES > INCLUIR

// Imagem 1
$('#inputImagemPacote1').on('change', function() { 
    let fileName = $(this).val().split('\\').pop(); 
    $(this).next('#labelImagemPacote1').addClass("selected").html(fileName); 
 });

 // Imagem 2
$('#inputImagemPacote2').on('change', function() { 
    let fileName = $(this).val().split('\\').pop(); 
    $(this).next('#labelImagemPacote2').addClass("selected").html(fileName); 
 });

 // Imagem 3
 $('#inputImagemPacote3').on('change', function() { 
    let fileName = $(this).val().split('\\').pop(); 
    $(this).next('#labelImagemPacote3').addClass("selected").html(fileName); 
 });

 // Imagem 4
 $('#inputImagemPacote4').on('change', function() { 
    let fileName = $(this).val().split('\\').pop(); 
    $(this).next('#labelImagemPacote4').addClass("selected").html(fileName); 
 });


/** Script para tratamento campo valor monetario
 *  Adicionar a classe valor moeda ao campo input
 */
$(document).ready(function(){
    $(".valorMoeda").inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'radixPoint': ",",
                'digitsOptional': false,
                'allowMinus': false,
                'prefix': 'R$ ',
                'placeholder': ''
    })
});