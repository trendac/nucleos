$(function(){
    $('#permissionGrid').w2grid({ 
        name: 'permissionGrid', 
        url: baseUrl+'permissions/',
        show: { 
            toolbar: true,
            footer: true,
            toolbarAdd: false,
            toolbarDelete: true,
            toolbarSave: false,
            toolbarEdit: true
        },
        searches: [				
            { field: 'name', caption: 'Permissão', type: 'text' },
            { field: 'description', caption: 'Observação', type: 'text' },
            { field: 'valida', caption: 'Permissão Válida?', type: 'list', items: ['Sim', 'Não'] }
        ],
        columns: [				
            { field: 'recid', caption: 'ID', size: '50px', sortable: true, attr: 'align=center' },
            { field: 'name', caption: 'Permissão', size: '25%', sortable: true },
            { field: 'description', caption: 'Observação', size: '45%', sortable: true },
            { field: 'totalFuncionalidades', caption: 'Funcionalidades Vinculadas', size: '170px', attr: "align=center" },
            { field: 'valida', caption: 'Permissão Válida?', size: '115px', attr: "align=center" },
            { field: 'modified', caption: 'Atualizado Em', size: '170px' }
        ],
        onEdit: function (event) {
            var id = w2ui.permissionGrid.getSelection();
            //location.href = baseUrl+'permissions/edit/'+id;
            w2popup.load({ 
                title: 'Editar: Permissão',
                url: baseUrl+'permissions/edit/'+id, 
                width: '700px',
                showMax: true
            });
        },
        onDelete: function (event) {
            event.preventDefault();
            var ids = w2ui.permissionGrid.getSelection();
            w2confirm('Deseja realmente excluir os registros selecionados?', function btn(answer) { 
                if(answer === '1'){
                    $.each(ids, function(i,v){
                        $.post(baseUrl+'permissions/delete/'+v, function(json){
                            if (json.error === 0){
                                w2ui['permissionGrid'].reload();
                                $("#add span").load(baseUrl+'permissions/checar/ #total');
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
            title: 'Lista de novas funcionalidades',
            url: baseUrl+'permissions/checar', 
            showMax: false,
            width: '700px',
            height: '450px',
            onOpen  : function (event) {
                event.onComplete = function () {
                    $('#grid').w2grid({ 
                        name: 'grid', 
                        show: { 
                            selectColumn: true,
                            footer: true
                        },
                        multiSelect: true,
                        columns: [				
                                { field: 'controller', caption: 'Controller', size: '60%' },
                                { field: 'action', caption: 'Action', size: '40%' }
                        ],
                        records: JSON.parse($('#data').html()),
                        onSelect: function(event) {
                            $('#adicionar').removeAttr('disabled');
                        },
                        onUnselect:  function(event) {
                            var total = parseInt($(w2ui.grid.getSelection()).length)-1;
                            if(total === 0){
                                $('#adicionar').attr('disabled','disabled');
                            }
                        }
                    });	
                    
                    $('#adicionar').click(function(){
                        w2ui.grid.lock('Processando', true);
                        $(this).attr('disabled','disabled');
                        var selected = w2ui.grid.getSelection().toString();
                        var url = baseUrl+'permissions/add/';
                        $.post(url, {data:selected}, function(json){
                            json = JSON.parse(json);
                            console.log(json);
                            if (json.error === 0){
                                w2popup.message({ 
                                    html: '<div style="padding-top: 20px; text-align: center">'+json.msg+'</div>', 
                                    width: 500, 
                                    height: 60,
                                    hideOnClick: true 
                                });
                                setTimeout(function(){location.reload();},1000);
                            } else {
                                $('#adicionar').removeAttr('disabled');
                            }
                        });
                    }).attr('disabled','disabled');
                };
            },
            onClose : function (event){
                event.onComplete = function () {
                    w2ui['grid'].destroy();
                };
            }
	});
        
        return false;
    });
});