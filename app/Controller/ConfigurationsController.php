<?php
/**
 * CakePHP ConfigurationsController
 * @author Gustavo Cardoso
 */
class ConfigurationsController extends AppController {
    
    var $uses = false;
    
    public function index() {   
        // DADOS USUÁRIOS
        App::import('Model', 'User');
        $thisUser = new User;
        
        $usuariosAtivos = $thisUser->find('count', array('conditions'=>array('User.active'=>1)));
        $usuariosInativos = $thisUser->find('count', array('conditions'=>array('User.active'=>0)));
        
        // DADOS GRUPOS
        App::import('Model', 'Group');
        $thisGroup = new Group;
        
        $gruposAtivos = $thisGroup->find('count', array('conditions'=>array('Group.active'=>1)));
        $gruposInativos = $thisGroup->find('count', array('conditions'=>array('Group.active'=>0)));
        
        $this->set(compact('usuariosAtivos','usuariosInativos','gruposAtivos','gruposInativos'));
        
        // DADOS FUNCIONALIDADES
        App::import('Model', 'Funcionalidade');
        $thisFuncionalidade = new Funcionalidade;
        
        $funcionalidadesAtivos = $thisFuncionalidade->find('count', array('conditions'=>array('Funcionalidade.active'=>1)));
        $funcionalidadesInativos = $thisFuncionalidade->find('count', array('conditions'=>array('Funcionalidade.active'=>0)));
        
        // DADOS PERMISSÕES
        App::import('Model', 'Permission');
        $thisPermission = new Permission;
        
        $permissoesAtivos = $thisPermission->find('count', array('conditions'=>array('Permission.totalFuncionalidades >'=>0)));
        $permissoesInativos = $thisPermission->find('count', array('conditions'=>array('Permission.totalFuncionalidades'=>0)));
        
        $this->set(compact('funcionalidadesAtivos','funcionalidadesInativos','permissoesAtivos','permissoesInativos'));
    }
    
}
