<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" style="font-size: 14px;font-weight: bold;" href="<?php echo $this->Html->url(array('controller'=>'configurations')); ?>">Configuração</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php echo $this->element('link', array('name'=>'Módulos','controller'=>'modulos')); ?>
                <?php echo $this->element('link', array('name'=>'Menu','controller'=>'menus')); ?>
                <li><a style="color: #CCCCCC">|</a></li>
                <?php echo $this->element('link', array('name'=>'Usuários','controller'=>'users')); ?>
                <?php echo $this->element('link', array('name'=>'Grupos','controller'=>'groups')); ?>
                <li><a style="color: #CCCCCC">|</a></li>
                <?php echo $this->element('link', array('name'=>'Funcionalidades','controller'=>'funcionalidades')); ?>
                <?php echo $this->element('link', array('name'=>'Permissões','controller'=>'permissions')); ?>
                <li><a style="color: #CCCCCC">|</a></li>
                <?php echo $this->element('link', array('name'=>'Parâmetros','controller'=>'parametros')); ?>
            </ul>
            <?php if(isset($button)){ ?>
            <ul class="nav navbar-nav navbar-right" style="padding-top: 8px;padding-right: 8px;">
                <?php echo $this->element('add', array('name'=>$button, 'value'=>$value));  ?>
            </ul>
            <?php }?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>