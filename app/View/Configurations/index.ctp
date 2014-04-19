<?php echo $this->element('menu/configurantion'); ?>   

<div class="panel panel-default">
    <div class="panel-heading">Últimas movimentações</div>
    <div class="panel-body">
        <span class="label label-default">Default</span>
        <span class="label label-primary">Primary</span>
        <span class="label label-success">Success</span>
        <span class="label label-info">Info</span>
        <span class="label label-warning">Warning</span>
        <span class="label label-danger">Danger</span>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #f5f5f5;">USUÁRIOS</li>
            <li class="list-group-item">
                <span class="badge"><?php echo $usuariosAtivos+$usuariosInativos; ?></span>
                Total
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $usuariosAtivos; ?></span>
                Ativos
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $usuariosInativos; ?></span>
                Inativos
            </li>
        </ul>
    </div>
    <div class="col-sm-6 col-md-3">
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #f5f5f5;">GRUPOS</li>
            <li class="list-group-item">
                <span class="badge"><?php echo $gruposAtivos+$gruposInativos; ?></span>
                Total
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $gruposAtivos; ?></span>
                Ativos
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $gruposInativos; ?></span>
                Inativos
            </li>
        </ul>
    </div>
    <div class="col-sm-6 col-md-3">
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #f5f5f5;">FUNCIONALIDADES</li>
            <li class="list-group-item">
                <span class="badge"><?php echo $funcionalidadesAtivos+$funcionalidadesInativos; ?></span>
                Total
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $funcionalidadesAtivos; ?></span>
                Ativos
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $funcionalidadesInativos; ?></span>
                Inativos
            </li>
        </ul>
    </div>
    <div class="col-sm-6 col-md-3">
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #f5f5f5;">PERMISSÕES</li>
            <li class="list-group-item">
                <span class="badge"><?php echo $permissoesAtivos+$permissoesInativos; ?></span>
                Total
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $permissoesAtivos; ?></span>
                Vinculadas a funcionalidade
            </li>
            <li class="list-group-item">
                <span class="badge"><?php echo $permissoesInativos; ?></span>
                Sem vínculo a funcionalidade
            </li>
        </ul>
    </div>
</div>