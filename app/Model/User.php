<?php
/**
 * CakePHP UserModel
 * @author Gustavo Cardoso
 */
class User extends AppModel {
    
    public $belongsTo = array('Group');
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN User.active = 1 THEN 'Sim' ELSE 'Não' END"
    );

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório.'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Formato de e-mail inválido.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'E-mail em uso. Favor informar outro e-mail.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório.'
            )
        )
    );
    
    public function beforeValidate($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        
        // VERIFICA O TIPO DE USUÁRIO QUE ESTÁ SENDO CADASTRADO OU ALTERADO
        $tipo = $this->Group->field('tipo', array('id'=>$this->data['User']['group_id']));
        
        if ($tipo == 'I'){
            $this->validator()->add('name', 'required', array('rule' => 'notEmpty','message'  => 'Nome obrigatório.', 'required' => true));
            $this->validator()->add('active', 'required', array('rule' => 'notEmpty','message'  => 'Ativo obrigatório.', 'required' => true));
        }
        
        return true;
    }
    
    /*
     * VERIFICA SE O USUÁRIO É ÚNICO
     */
    public function validaUsuarioUnico(){
        
    }
}
