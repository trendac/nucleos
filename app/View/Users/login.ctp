<?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => 'col col-md-3 control-label'), 'wrapInput' => 'col col-md-9', 'class' => 'form-control'), 'class' => 'well form-horizontal')); ?>
<?php echo $this->Form->input('username', array('label'=>'Login','placeholder' => 'Usuário ou E-mail', 'style'=>'padding: 6px 12px !important;')); ?>
<?php echo $this->Form->input('password', array('label'=>'Senha','placeholder' => 'Senha', 'style'=>'padding: 6px 12px !important;')); ?>
<div class="form-group">
    <?php echo $this->Form->submit('Entrar', array('div' => 'col col-md-1 col-md-offset-3','class' => 'btn btn-default'));?> 
    <div class="col col-md-1 col-md-offset-1" style="width:20px;margin-left: 0;padding-top: 6px;text-align: center;">ou</div>
    <?php echo $this->Form->button('Cadastrar Senha de Acesso', array('type'=>'button', 'onclick'=>"javascript:location.href='assign'",'div' => 'col col-md-1 col-md-offset-1','class' => 'btn btn-default', 'style'=>'margin-left:33px;'));?>
    <?php echo $this->Form->button('Recuperar Senha de Acesso', array('type'=>'button', 'onclick'=>"javascript:location.href='recuperar'",'div' => 'col col-md-1 col-md-offset-1','class' => 'btn btn-default', 'style'=>'margin-right: 15px;float: right;'));?>
</div>
<?php echo $this->Form->end(); ?>