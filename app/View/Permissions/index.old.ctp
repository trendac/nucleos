<?php 
$aux = array();
$count = 0;
foreach($permissions as $k => $permission){
    $aux[$k]['recid'] = $permission['Permission']['id'];
    $aux[$k]['description'] = $permission['Permission']['description'];
    $aux[$k]['name'] = $permission['Permission']['name'];
    $aux[$k]['created'] = $permission['Permission']['created'];
} 
?>
<div id="permissionData" style="display:none;"><?php echo json_encode($aux); ?></div>

<button id="checar" type="button" class="btn btn-primary" style="float:right;margin-top: 15px;">Checar Funcionalidades nos Controllers</button>
<h3><b>Funcionalidades</b></h3> 

<div id="permissionGrid" style="width: 100%; height: 400px;"></div>

<div class="bs-example">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>Funcionalidade</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission): ?>
            <tr>
                <td><?php echo $permission['Permission']['id']; ?></td>
                <td><?php echo $this->Html->link($permission['Permission']['description'], array('controller' => 'permissions', 'action' => 'view', $permission['Permission']['id'])); ?></td>
                <td><?php echo $permission['Permission']['name']; ?></td>
                <td><?php echo $permission['Permission']['created']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php echo $this->Html->script('permissions', array('inline' => false)); ?>