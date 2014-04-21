<?php echo $this->element('menu/configurantion', array('button'=>'Adicionar Permissões', 'value'=>$adicionar));  ?>
<?php if (count($permissoesNaoVinculadas) > 0){ ?>
<?php echo $this->element('warning', array('msg'=>'Existem <strong>'.count($permissoesNaoVinculadas).'</strong> permissões não vinculadas a funcionalidades.')); ?>
<?php }?>
<?php if ($remover < 0){ ?>
<?php echo $this->element('danger', array('msg'=>'Existem <strong>'.abs($remover).'</strong> permissões não válidas. Favor verificar se o controllerction existe ou exclua os registros.')); ?>
<?php }?>
<div id="permissionGrid" style="width: 100%; height: 400px;"></div>
<?php echo $this->Html->script('configurantion/permissions', array('inline' => false)); ?>