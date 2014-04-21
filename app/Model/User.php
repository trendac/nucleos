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
                'message' => 'Campo obrigatório.',
                'last'  => false
            ),
            'validaAlteracaoSenha' => array(
                'rule' => 'validaAlteracaoSenha',
                'message' => 'Nova Senha não confere com Confirmar Senha.',
            )
        )
    );
    
    /*
     * TRATA INFORMAÇÕES ANTES DE SALVAR
     */
    public function beforeValidate($options = array()) {
        // VERIFICA SE A SENHA ESTÁ SENDO ALTERADA
        if (isset($this->data['User']['password']) && isset($this->data['User']['confirmacao'])){
            // REMOVE A VALIDAÇÃO DO CAMPO USERNAME, NAME E ACTIVE
            unset($this->validate['username']); 
            unset($this->validate['name']);
            unset($this->validate['active']);
        } else {
            // REMOVE A VALIDAÇÃO DE ALTERAÇÃO DE SENHA DO CAMPO PASSWORD
            unset($this->validate['password']['validaAlteracaoSenha']);
        }

        // ENCRIPTA A SENHA
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
            $this->data['User']['confirmacao'] = AuthComponent::password($this->data['User']['confirmacao']);
        }

        // VERIFICA O TIPO DE USUÁRIO QUE ESTÁ SENDO CADASTRADO OU ALTERADO
        $tipo = $this->Group->field('tipo', array('id'=>$this->data['User']['group_id']));
        
        // VERIFICA NOME E ATIVO QUANDO O CADASTRO É DE PERFIS INTERNOS
        if ($tipo == 'I'){
            $this->validate['name'] = array('required' => array('rule' => 'notEmpty','message'  => 'Nome obrigatório.', 'required' => true));
            $this->validate['active'] = array('required' => array('rule' => 'notEmpty','message'  => 'Ativo obrigatório.', 'required' => true));
        }
        
        return true;
    }
    
    /*
     * VALIDA ALTERAÇÃO DE SENHA
     */
    public function validaAlteracaoSenha(){
        $ok = true;

        if (isset($this->data['User']['password']) && isset($this->data['User']['confirmacao'])){
            $senha = $this->data['User']['password'];
            $confirmacao = $this->data['User']['confirmacao'];
            
            // REMOVE A VALIDAÇÃO DO CAMPO USERNAME
            unset($this->validate['username']);

            // VERIFICA SE A SENHA SÃO IGUAIS
            if ($senha != $confirmacao){
                $ok = false;
            }
        } 
        
        return $ok;
    }
}
