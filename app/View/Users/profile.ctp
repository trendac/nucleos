<div class="col-xs-8" style="padding-left: 0px;">
    <div id="header" style="<?php echo ($this->request->is('ajax')) ? 'display:none' : ''; ?>">
        <h3><b>Minha Conta</b></h3> 
    </div>
    <?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => ''),'wrapInput' => '','class' => 'form-control'),'class' => 'well', 'style' => 'margin-top:10px;')); ?>
        <div class="row">
            <?php echo $this->Form->input('name', array('label'=>'Nome','placeholder' => 'Nome e Sobrenome','div'=>array('class'=>'col-xs-7'))); ?>
            <?php echo $this->Form->input('group_id', array('label'=>'Perfil', 'readonly'=>'true','div'=>array('class'=>'col-xs-5'))); ?>
        </div>
        <div class="row" style="margin-top:20px;">
            <?php echo $this->Form->input('username', array('label'=>'E-mail','placeholder' => 'E-mail','div'=>array('class'=>'col-xs-12'))); ?>
        </div>
        <?php echo $this->Form->hidden('active'); ?>
        <?php echo $this->Form->hidden('id'); ?>
        <?php echo $this->Form->submit('ATUALIZAR DADOS', array('div' => array('class'=>'row col-xs-12', 'style'=>'margin-top:20px;'),'class' => 'btn btn-success', 'style'=>'font-size:11px'));?>
    <?php echo $this->Form->end(); ?>
</div>

<div class="col-xs-4" style="padding-right: 0px;">
    <div id="header" style="<?php echo ($this->request->is('ajax')) ? 'display:none' : ''; ?>">
        <h3><b>Alterar Senha</b></h3> 
    </div>
    <?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'form-group','label' => array('class' => ''),'wrapInput' => '','class' => 'form-control'),'class' => 'well', 'style' => 'margin-top:10px;')); ?>
        <div class="row">
            <?php echo $this->Form->input('password', array('type'=>'password', 'label'=>'Nova Senha','placeholder' => 'Informe sua senha nova','div'=>array('class'=>'col-xs-12'), 'style'=>'padding: 6px 12px !important;')); ?>
        </div>
        <div class="row" style="margin-top:20px;">         
            <?php echo $this->Form->input('confirmacao', array('type'=>'password', 'label'=>'Confirmar Senha','placeholder' => 'Confirme sua nova senha','div'=>array('class'=>'col-xs-12'), 'style'=>'padding: 6px 12px !important;')); ?>
        </div>
        <?php echo $this->Form->hidden('id'); ?>
        <?php echo $this->Form->submit('ALTERAR SENHA', array('div' => array('class'=>'row col-xs-12', 'style'=>'margin-top:20px;'),'class' => 'btn btn-success', 'style'=>'font-size:11px'));?>
    <?php echo $this->Form->end(); ?>
</div>