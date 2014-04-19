<?php
/**
 * CakePHP UsersController
 * @author Gustavo Cardoso
 */
class UsersController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('assign', 'logout', 'recuperar'); // Permitindo que os usuários se registrem
    }
    
    public function index() {   
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->User->recursive = 1;
        
        //FILTRO INICIAL
        $options = array_merge($options, array('conditions'=>array('Group.tipo'=>'I')));
        
        // PEGA FUNCIONALIDADES CADASTRADAS
        $dados = $this->User->find('all', $options);
        
        // ESTILIZA LINHA DA GRID
        foreach($dados as $k => $v){
            if ($v['User']['ativo'] != 'Sim') {
                $dados[$k]['User']['style'] = 'background-color: #F2C9CA';
            }
        }

        // SE AJAX RENDERIZA COMO JSON
        if($this->request->is('ajax')){ 
            // PREPARA DADOS
            foreach($dados as $k => $v){
                $records[] = $v['User'];
                $records[$k]['group_name'] = $v['Group']['name'];
            }

            // CALCULA O TOTAL DE REGISTROS
            $total = count($dados);
            
            // ENVIA DADOS PARA A VIEW
            echo json_encode(compact('total','records'));
            exit;
        }
    }
    
    public function add() {
        // PEGA LISTA DE GRUPOS ATIVOS
        $this->set('groups', $this->User->Group->find('list', array('conditions'=>array('Group.tipo'=>'I'))));
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                //$this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                if($this->request->is('ajax')){ 
                    $error = 0;
                    $url = Router::url(array('action'=>'index'), true);
                    echo json_encode(compact('error','url'));
                    exit;
                } else {
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }
    
    public function edit($id = null) {
        // PEGA LISTA DE GRUPOS ATIVOS
        $this->set('groups', $this->User->Group->find('list', array('conditions'=>array('Group.tipo'=>'I'))));
        
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                //$this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                if($this->request->is('ajax')){ 
                    $error = 0;
                    $url = Router::url(array('action'=>'index'), true);
                    echo json_encode(compact('error','url'));
                    exit;
                } else {
                    $this->redirect(array('action' => 'login'));
                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }    
    public function profile() {
        // PEGA ID DA SESSÃO
        $id = $this->Session->read('Auth.User.id');
        
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Dados da conta atualizados com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'profile'));
//                if($this->request->is('ajax')){ 
//                    $error = 0;
//                    $url = Router::url(array('action'=>'index'), true);
//                    echo json_encode(compact('error','url'));
//                    exit;
//                } else {
//                    $this->redirect(array('action' => 'login'));
//                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
            
            // PEGA LISTA DE GRUPOS ATIVOS
            $this->set('groups', $this->User->Group->find('list', array('conditions'=>array('Group.id'=>$this->request->data['User']['group_id']))));
        }
    }
    
    public function delete($id = null) {
        // INICIALIZA VARIÁVEIS
        $error = 0;
        $msg = 'Registro excluído com sucesso.';
        $this->autoRender = ($this->request->is('ajax')) ? false : true;
        
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            $msg = 'Registro inexistente.';
        }
        
        if (!$this->User->delete()) {
            $error = 1;
            $msg = 'Não foi possível excluir o registro. Favor tentar novamente.';
        }
        
        echo json_encode(compact('error','msg'));
        exit;
    }
    
    public function recuperar() {
        if ($this->request->is('post')) {
            $count = $this->User->find('count', array('conditions'=> array('username'=>$this->request->data['User']['username'])));
            
            if ($count == 1) {
                $this->Session->setFlash(__('Um pedido de confirmação foi encaminhado para seu e-mail. Favor verificar sua caixa de entrada e seguir as instruções.'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash('O e-mail informado não está em uso, portanto não pode ser recuperado. Favor verificar o e-mail informado e tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            if($this->Session->check('Message.flash')){
                $this->Session->setFlash($this->Session->read('Message.flash.message'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Para recuperar sua senha de acesso informe seu login e clique em <b>Recuperar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
            }
        }
	}
    
    public function assign() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Senha de acesso cadastrada com sucesso. Informe seu login e senha e comece a experimentar agora.'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash('Não foi possível cadastrar a senha. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }
    
    public function login() {
        if ($this->request->is('post')) {
            // VERIFICA SE O USUÁRIO ESTÁ AUTORIZADO A ENTRAR NO SISTEMA
            if ($this->Auth->login()) {
                // LIBERA O ACESSO A APLICAÇÕES
                // TODO: CRIAR CRUD PARA CADASTRO DE FUNCIONALIDADES PARA LIBERAÇÃO DE ACESSO
                $dados = $this->Session->read('Auth.User');
                
                // REDIRECIONA PARA A HOME DO SISTEMA
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Login e/ou Senha incorretos...', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            if($this->Session->check('Message.flash')){
                $this->Session->setFlash($this->Session->read('Message.flash.message'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Para acessar informe seu login e senha e clique em <b>Entrar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
            }
        }
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}
