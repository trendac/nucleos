<?php if ($this->Session->check('Auth.User')){ ?>
<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="min-width: 160px;">
        	<?php echo ($this->Session->read('Auth.User.name') != '') ? $this->Session->read('Auth.User.name') : $this->Session->read('Auth.User.username'); ?> 
	    	<b class="caret"></b>
	    </a>
        <ul class="dropdown-menu">
            <li><?php echo $this->Html->link('Minha Conta', array('controller'=>'users', 'action'=>'profile')); ?></li>
            <li><?php echo $this->Html->link('Configurações', array('controller'=>'configurations')); ?></li>
            <li class="divider"></li>
            <li><?php echo $this->Html->link('Sair', array('controller'=>'users', 'action'=>'logout'),null , 'Deseja realmente sair?'); ?></li>
        </ul>
    </li>
</ul>
<?php } ?>