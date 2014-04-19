<?php
/**
 * CakePHP ModuloModel
 * @author Gustavo Cardoso
 */
class Modulo extends AppModel {
    
    public $hasMany = array('Funcionalidade');
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN Modulo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'totalFuncionalidades' => "(SELECT count(1) FROM funcionalidades WHERE Modulo.id = funcionalidades.modulo_id)",
    );
    
    public $order = 'Modulo.name asc';

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
    );
    
    public function afterSave($created, $options = array()) {
        // ASSOCIA FUNCIONALIDADES AO MÓDULO
        foreach($this->data['Modulo']['funcionalidade'] as $v){
            $this->Funcionalidade->id = $v;
            $this->Funcionalidade->saveField('modulo_id', $this->data['Modulo']['id']);
        }
        
        parent::afterSave($created, $options);
    }
}
