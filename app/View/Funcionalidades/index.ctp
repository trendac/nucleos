<?php echo $this->element('menu/configurantion', array('button'=>'Novo', 'value'=>@$adicionar)); ?>    
<?php if (count($permissoesNaoVinculadas) > 0){ ?>
<?php echo $this->element('warning', array('msg'=>'Existe(m) <strong>'.count($permissoesNaoVinculadas).'</strong> funcionalidade(s) sem permissões vinculadas.')); ?>
<?php }?>
<div id="dataGrid" style="width: 100%; height: 400px;"></div>
<?php echo $this->Html->script('configurantion/funcionalidades', array('inline' => false)); ?>