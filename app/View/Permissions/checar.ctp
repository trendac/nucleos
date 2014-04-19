<?php 
$aux = array();
$count = 0;
foreach($dados as $controller => $dado){
    foreach($dado as $v){
        $aux[$count]['recid'] = $controller.'.'.$v;
        $aux[$count]['controller'] = $controller;
        $aux[$count]['action'] = $v;
        $count++;
    }
} 
?>
<div id="data" style="display:none;"><?php echo json_encode($aux); ?></div>
<div style="margin-top:10px;">Permissões encontradas: <span id="total"><?php echo $count; ?></span></div>
<div id="grid" style="margin-top: 10px;width: 685px; height: 335px;"></div>
<input id="adicionar" type="button" value="+ ADICIONAR SELECIONADOS" style="margin-top: 10px;">