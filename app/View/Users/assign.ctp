<?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => 'col col-md-3 control-label'),'wrapInput' => 'col col-md-9','class' => 'form-control'),'class' => 'well form-horizontal')); ?>
<fieldset>
    <legend><?php echo __('Cadatrar Senha de Acesso'); ?></legend>
    <?php echo $this->Form->input('username', array('label'=>'Login','placeholder' => 'E-mail', 'style'=>'padding: 6px 12px !important;')); ?>
    <?php echo $this->Form->input('password', array('label'=>'Senha','placeholder' => 'Senha', 'style'=>'padding: 6px 12px !important;')); ?>
    <?php echo $this->Form->hidden('group_id', array('value'=>2));?>
    <div class="form-group">
        <?php echo $this->Form->submit('Cadastrar', array('div' => 'col col-md-1 col-md-offset-3','class' => 'btn btn-default'));?> 
        <div class="col col-md-1 col-md-offset-1" style="width:20px;margin-left: 23px;padding-top: 6px;text-align: center;">ou</div>
        <?php echo $this->Form->button('Voltar', array('type'=>'button', 'onclick'=>"javascript:location.href='login'",'div' => 'col col-md-1 col-md-offset-1','class' => 'btn btn-default', 'style'=>'margin-left:33px;'));?>
    </div>
</fieldset>
<?php echo $this->Form->end(); ?>