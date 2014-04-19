<?php echo $this->element('menu/configurantion', array('button'=>'Novo', 'value'=>@$adicionar));  ?>    
<?php if (count($gruposSemFuncionalidades) > 0){ ?>
<?php echo $this->element('warning', array('msg'=>'Existe(m) <strong>'.count($gruposSemFuncionalidades).'</strong> grupo(s) sem funcionalidades vinculadas.')); ?>
<?php }?>
<div id="dataGrid" style="width: 100%; height: 400px;"></div>
<?php echo $this->Html->script('configurantion/groups', array('inline' => false)); ?>