<?php
/**
 * CakePHP FuncionalidadeModel
 * @author Gustavo Cardoso
 */
class Funcionalidade extends AppModel {
    
    public $hasAndBelongsToMany = array('Permission');
    
    public $belongsTo = array('Modulo');

    public $virtualFields = array(
        'ativo' => "CASE WHEN Funcionalidade.active = 1 THEN 'Sim' ELSE 'Não' END",
        'totalPermissoes' => "(SELECT count(1) FROM funcionalidades_permissions WHERE Funcionalidade.id = funcionalidades_permissions.funcionalidade_id)",
        'modulo' => "(SELECT modulos.name FROM modulos WHERE modulos.id = modulo_id)",
    );
    
    public $order = 'Funcionalidade.modulo asc, Funcionalidade.name asc';

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
        )
    );
    
    public function afterSave($created, $options = array()) {
        // VERIFICIA SE FORAM PASSADAS PEMISSÕES COMO PARÂMETROS
        if (isset($this->data['Funcionalidade']['permission'])){
            // PREPARA DADOS
            $dados = $this->_extractFieldsHABTM($this->data['Funcionalidade']['permission'], $this->data['Funcionalidade']['id'], 'funcionalidade_id', 'permission_id');

            // APAGA REGISTROS RELACIONADOS AO ID
            $this->FuncionalidadesPermission->deleteAll(array('funcionalidade_id'=>$this->data['Funcionalidade']['id']));

            // ASSOCIA PERMISSÕES A FUNCIONALIDADE
            $this->FuncionalidadesPermission->saveAll($dados);
        }
        
        parent::afterSave($created, $options);
    }
    
    public function findPermissoesNaoVinculadas(){
        return $this->find('list', array(
            'conditions'=>array('totalPermissoes'=>'0'))
        );
    }
}
