<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Hash', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
        'Session',
        'DebugKit.Toolbar',
        'Auth' => array(
            'authorize' => array(
                'Controller'
            ), 
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'pages', 
                'action' => 'display', 'home'
            ),
            'logoutRedirect' => array(
                'controller' => 'pages', 
                'action' => 'display', 'home'
            ),
            'authError' => 'Você não tem permissão para acessar: ',
            'flash' => array(
                'element' => 'alert',
                'key' => 'auth',
                'params' => array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                )
            )
        )
    );
    
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );
    
    var $layout = 'bootstrap3';
    
    public function isAuthorized($user) {
        App::import('Model','Group');
        $thisGroup = new Group;
        
        $thisGroup->recursive = 2;
        $data = $thisGroup->find('all', array('conditions'=>array('id'=>$user['Group']['id'])));
        
        $permissao = $this->request->params['controller'].'.'.$this->request->params['action'];
        $temPermissao = in_array($permissao, Hash::extract($data[0], 'Funcionalidade.{n}.Permission.{n}.name'));
        
        if (!$temPermissao){
            $dados = $thisGroup->Funcionalidade->Permission->find('all', array('conditions' => array('Permission.name =' => $permissao)));
            if (isset($dados[0])){
                $this->Session->setFlash($this->Auth->authError.' <b>'.$dados[0]['Funcionalidade'][0]['name'].'</b>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            } else {
                $this->Session->setFlash($this->Auth->authError.' <b> Não cadastrado</b>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        
        return $temPermissao;
    }
    
    public function _preparaCampos ($data){
        foreach ($data as $k => $v){
            $data[$k]['field'] = implode('.',explode('_',$v['field']));
        }
        return $data;
    }
    
    public function _index(){
        // INICIALIZA VARIÁVEIS
        $order = '';
        $conditions = '';
        
        // CASO SEJA INFORMADO CAMPOS DE ORDENAÇÃO CRIA ORDER
        if(isset($this->request->data['sort']) && !empty($this->data['sort'])){
            // VERIFICA SE EXISTEM CAMPOS DE OUTRAS TABELAS PARA PREPARAR A QUERY
            $this->request->data['sort'] = $this->_preparaCampos($this->data['sort']);
            
            // ACRESCENTA O CAMPO RECID
            foreach ($this->request->data['sort'] as $v){
                $order[] = ($v['field'] == 'recid') ? $this->uses[0].'.id '.$v['direction'] : $this->modelClass.'.'.$v['field'].' '.$v['direction'];
            }
            
            $order = implode(',', $order);
        } else {
            unset($order);
        }
        
        // CASO SEJA INFORMADO CAMPOS DE PESQUISA CRIA CONDITION
        if(isset($this->request->data['search']) && !empty($this->request->data['search'])){
            
            // VERIFICA SE EXISTEM CAMPOS DE OUTRAS TABELAS PARA PREPARAR A QUERY
            $this->request->data['search'] = $this->_preparaCampos($this->data['search']);
            
            foreach ($this->request->data['search'] as $v){
                // VERIFICA OPERADOR UTILIZADO E CUSTOMIZA QUERY
                switch ($v['operator']) {
                    case 'contains':
                        $conditions[$this->request->data['search-logic']][] = array($v['field'].' LIKE ' => '%'.$v['value'].'%');
                        break;
                    case 'is':
                        $conditions[$this->request->data['search-logic']][] = array($v['field'] => $v['value']);
                        break;
                    case 'begins with':
                        $conditions[$this->request->data['search-logic']][] = array($v['field'].' LIKE ' => $v['value'].'%');
                        break;
                    case 'ends with':
                        $conditions[$this->request->data['search-logic']][] = array($v['field'].' LIKE ' => '%'.$v['value']);
                        break;
                }
            }
        }
        
        return compact('order', 'conditions');
    }
    
    public function _delete($id = null) {
        // INICIALIZA VARIÁVEIS
        $error = 0;
        $msg = 'Registro excluído com sucesso.';
        $this->autoRender = ($this->request->is('ajax')) ? false : true;
        $model = $this->modelClass;
        
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $this->$model->id = $id;
        
        if (!$this->$model->exists()) {
            $msg = 'Registro inexistente.';
        }
        
        if (!$this->$model->delete()) {
            $error = 1;
            $msg = 'Não foi possível excluir o registro. Favor tentar novamente.';
        }
        
        echo json_encode(compact('error','msg'));
        exit;
    }
}
