$(document).ready(function() { 
    // CONDIGURA CAMPO TIPO MULTISELECT
    $(".chosen-select").chosen();
    
    // CONFIGURA FORMULÁRIO
    $('form').bind("submit", function() {
        
        // INICIALIZA VARIÁVEIS
        var self = $(this);
        
        // TRAVA O FORMULÁRIO
        w2popup.lock('Processando...', true);
        
        // CONTROLA O EVENTO SUBMIT DO FORMULÁRIO
        $(this).ajaxSubmit({
            dataType: 'html',
            success: function(html){
                // SETA VARIÁVEIS INICIÁIS
                
                // DESTRAVA FORMULÁRIO
                w2popup.unlock();
                
                //VERIFICA SE TEVE ERRO
                if (html.charAt(0) !== '{'){
                    self.html($(html).find('form').html());
                } else {
                    //var json = JSON.parse(html);
                    //location.href = json.url;
                    w2ui['dataGrid'].reload();
                    w2popup.close();
                    $('.alert').remove();
                    $('body .container:last').prepend('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">×</a>Registro salvo com sucesso.</div>');
                }
            }
        }); 
        return false;
    });
    
});