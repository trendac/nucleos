<div id="header" style="<?php echo ($this->request->is('ajax')) ? 'display:none' : ''; ?>">
    <?php echo $this->element('back', array('name'=>'Voltar','url'=>$this->Html->url(array('controller'=>'users','action'=>'index'))));  ?>
    <h3><b>Usuários</b></h3> 
</div>
<?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => ''),'wrapInput' => '','class' => 'form-control'),'class' => 'well', 'style' => 'margin-top:10px;')); ?>
<fieldset>
    <?php echo $this->Form->input('name', array('label'=>'Nome','placeholder' => 'Nome e Sobrenome')); ?>
    <?php echo $this->Form->input('username', array('label'=>'Usuários','placeholder' => 'E-mail')); ?>
    <?php echo $this->Form->input('group_id', array('label'=>'Grupo')); ?>
    <?php echo $this->Form->input('active', array('label'=>'Ativo', 'options' => array(1=>'Sim', 0=>'Não'),'empty' => 'Selecione')); ?>
    <div class="form-group">
        <?php echo $this->Form->submit('Salvar', array('div' => '','class' => 'btn btn-default'));?>         
    </div>
</fieldset>
<?php echo $this->Form->end(); ?>
<?php echo $this->Html->script('formularios', array('inline' => false)); ?>