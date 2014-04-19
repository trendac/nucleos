<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NucleOS :: v 1.0</title>
        <?php 
        //echo $this->Html->meta('icon')."\n\t"; 
        echo $this->fetch('meta')."\n\t";
        echo $this->Html->css('bootstrap.min')."\n\t"; 
        echo $this->Html->css('w2ui-1.3.2.min')."\n\t"; 
        echo $this->Html->css('basics')."\n\t"; 
        echo $this->Html->css('../js/chosen_v1.1.0/chosen.min')."\n\t"; 
        ?><!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]--><?php
        echo $this->fetch('css')."\n";
        ?>
        <script>baseUrl = "<?php echo $this->Html->url('/'); ?>";</script>
    </head>
    <body style="overflow-y: scroll;">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header"><?php echo $this->Html->link('NucleOS :: v 1.0', array('controller' => '/',), array('class' => 'navbar-brand'));?></div>
                <?php echo $this->element('menu/topo'); ?>
            </div>
        </nav>

        <div class="container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        </div>
        
        <?php echo $this->Html->script('jquery-2.1.0.min')."\n"; ?>
        <?php echo $this->Html->script('bootstrap.min')."\n"; ?>
        <?php //echo $this->Html->script('run_prettify')."\n"; ?>
        <?php echo $this->Html->script('w2ui-1.3.2.min')."\n"; ?>
        <?php echo $this->Html->script('jquery.form.min')."\n"; ?>
        <?php echo $this->Html->script('chosen_v1.1.0/chosen.jquery.min')."\n"; ?>
        <?php echo $this->fetch('script')."\n"; ?>
    </body>
</html>
