<?php
/**
 * CakePHP GroupModel
 * @author Gustavo Cardoso
 */
class Group extends AppModel {
    
    public $hasMany = array('User');
    
    public $hasAndBelongsToMany = array('Funcionalidade');
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN Group.active = 1 THEN 'Sim' ELSE 'Não' END",
        'tipoExtenso' => "CASE WHEN Group.tipo = 'I' THEN 'Interno' ELSE 'Externo' END",
        'totalFuncionalidades' => "(SELECT count(1) FROM funcionalidades_groups WHERE Group.id = funcionalidades_groups.group_id)",
        'totalUsuarios' => "(SELECT count(1) FROM users WHERE Group.id = users.group_id)",
    );
    
    public $order = 'Group.tipo desc, Group.name asc';

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro.'
            )
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'tipo' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    );
    
    public function afterSave($created, $options = array()) {
        // PREPARA DADOS
        $dados = $this->_extractFieldsHABTM($this->data['Group']['funcionalidade'], $this->data['Group']['id'], 'group_id', 'funcionalidade_id');

        // APAGA REGISTROS RELACIONADOS AO ID
        $this->FuncionalidadesGroup->deleteAll(array('group_id'=>$this->data['Group']['id']));
        
        // ASSOCIA PERMISSÕES A FUNCIONALIDADE
        $this->FuncionalidadesGroup->saveAll($dados);
        
        parent::afterSave($created, $options);
    }
    
    public function gruposSemFunctionalidades(){
        return $this->find('list', array('conditions'=>array('totalFuncionalidades'=>0)));
    }
}
