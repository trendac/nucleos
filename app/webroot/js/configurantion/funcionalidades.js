$(function(){
    var table = 'funcionalidades';
    
    $('#dataGrid').w2grid({ 
        name: 'dataGrid', 
        url: baseUrl+table+'/',
        show: { 
            toolbar: true,
            footer: true,
            toolbarAdd: false,
            toolbarDelete: true,
            toolbarSave: false,
            toolbarEdit: true
        },
        searches: [				
            { field: 'name', caption: 'Nome', type: 'text' },
            { field: 'ativo', caption: 'Ativo', type: 'list', items: ['Sim', 'Não'] },
        ],
        columns: [				
            { field: 'recid', caption: 'ID', size: '50px', sortable: true, attr: 'align=center' },
            { field: 'modulo', caption: 'Módulo', size: '15%', sortable: true },
            { field: 'name', caption: 'Nome', size: '25%', sortable: true },
            { field: 'totalPermissoes', caption: 'Permissões Vinculadas', size: '140px', attr: "align=center", sortable: true },
            { field: 'ativo', caption: 'Ativo', size: '80px', attr: "align=center" },
            { field: 'modified', caption: 'Atualizado Em', size: '170px' }
        ],
        onEdit: function (event) {
            var id = w2ui.dataGrid.getSelection();
            w2popup.load({ 
                title: 'Editar: Funcionalidade',
                url: baseUrl+table+'/edit/'+id, 
                width: '700px',
                height: '380px',
                showMax: true
            });
        },
        onDelete: function (event) {
            event.preventDefault();
            var ids = w2ui.dataGrid.getSelection();
            w2confirm('Deseja realmente excluir os registros selecionados?', function btn(answer) { 
                if(answer === '1'){
                    $.each(ids, function(i,v){
                        $.post(baseUrl+table+'/delete/'+v, function(json){
                            if (json.error === 0){
                                w2ui['dataGrid'].reload();
                            } else {
                                w2alert('Não foi possível excluir o registro. Favor tentar novamente mais tarde');
                            }
                        },'json');
                    });
                    
                }
            });
        }
    });
    
    $('#add').click(function(){
        w2popup.load({ 
            title: 'Cadastrar: Funcionalidade',
            url: baseUrl+table+'/add', 
            width: '700px',
            height: '380px',
            showMax: true
        });
        
        return false;
    });
});