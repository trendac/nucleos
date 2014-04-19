<?php
/**
 * CakePHP UserModel
 * @author Gustavo Cardoso
 */
class Permission extends AppModel {
    
    public $hasAndBelongsToMany = array('Funcionalidade');
    
    var $order = "Permission.name asc";
    
    public $virtualFields = array(
        'totalFuncionalidades' => "(SELECT count(1) FROM funcionalidades_permissions WHERE Permission.id = funcionalidades_permissions.permission_id)",
    );
    
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public function findPermissoesNaoVinculadas(){
        return $this->find('list', array(
            'joins' => array(
                array(
                    'table' => 'funcionalidades_permissions',
                    'alias' => 'FuncionalidadesPermission',
                    'type' => 'LEFT',
                    'conditions' => array('Permission.id = FuncionalidadesPermission.permission_id')
                )
            ),
            'conditions'=>array('FuncionalidadesPermission.id IS NULL'))
        );
    }
}
