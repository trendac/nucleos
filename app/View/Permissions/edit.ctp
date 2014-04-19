<div id="header" style="<?php echo ($this->request->is('ajax')) ? 'display:none' : ''; ?>">
    <?php echo $this->element('back', array('name'=>'Voltar','url'=>$this->Html->url(array('controller'=>'permissions','action'=>'index'))));  ?>
    <h3><b>Permissões</b></h3> 
</div>
<?php echo $this->Form->create('Permission', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => ''),'wrapInput' => '','class' => 'form-control'),'class' => 'well', 'style' => 'margin-top:10px;')); ?>
<fieldset>
    <?php echo $this->Form->input('name', array('label'=>'Permissão (controller.action)','placeholder' => 'Permissão')); ?>
    <?php echo $this->Form->input('description', array('label'=>'Observação da permissão','placeholder' => 'Descrição')); ?>
    <div class="form-group">
        <?php echo $this->Form->submit('Salvar', array('div' => '','class' => 'btn btn-default'));?>         
    </div>
</fieldset>
<?php echo $this->Form->end(); ?>