<?php
/**
 * CakePHP Permissions
 * @author Gustavo Cardoso
 */
class PermissionsController extends AppController  {
    
    public $components = array('ControllerList');
    
    public function index() {
        // TRATA PARÂMETROS QUE NÃO FAZEM PARTE DA QUERY
        $valida = null;
        if (isset($this->request->data['search'])){
            foreach($this->request->data['search'] as $k => $v){
                if ($v['field'] === 'valida'){
                    $valida = $this->request->data['search'][$k]['value'];
                    unset($this->request->data['search'][$k]);
                }
            }
        }
        
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->Permission->recursive = 0;

        // PEGA PERMISSÕES CADASTRADAS
        $permissions = $this->Permission->find('all', $options);
        
        // PEGA LISTA DE PERMISSÕES DISPONÍVEIS
        $dados = $this->ControllerList->get();
        $aux = array();
        foreach($dados as $k => $v){
            foreach($v as $m){
                $aux[] = $k.'.'.$m;
            }
        }
        
        // PERMISSÕES NÃO VINCULADAS
        $this->set('permissoesNaoVinculadas',$this->Permission->findPermissoesNaoVinculadas());
        
        // VERIFICA SE A PERMISSÃO EXISTE NO CONTROLLER
        foreach($permissions as $k => $v){
            if (in_array($v['Permission']['name'], $aux)) {
                $permissions[$k]['Permission']['valida'] = 'Sim';
            } else {
                $permissions[$k]['Permission']['valida'] = 'Não';
                $permissions[$k]['Permission']['style'] = 'background-color: #F2C9CA';
            }
            
            if ($permissions[$k]['Permission']['totalFuncionalidades'] == 0){
                $permissions[$k]['Permission']['style'] = 'background-color: #fbeed5';
            }

            if ($permissions[$k]['Permission']['valida'] != $valida && $valida != null){
                unset($permissions[$k]);
            }
        }
        
        // PREPARA DADOS
        foreach($permissions as $k => $v){
            $records[] = $v['Permission'];
        }

        // CALCULA O TOTAL DE REGISTROS
        $total = count($permissions);
        
        // SE AJAX RENDERIZA COMO JSON
        if($this->request->is('ajax')){ 
            // ENVIA DADOS PARA A VIEW
            echo json_encode(compact('total','records'));
            exit;
        }
        
        // ENVIA PARA A VIEW O TOTAL DE PERMISSÕES A ADICIONAR
        $this->set(array('adicionar'=>count($aux)-count($permissions)));
	}
    
    public function add(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        
        $data = explode(',', $this->data);
        $error = 0;
        $msg = 'Funcionalidade(s) adicionada(s) com sucesso.';
        
        foreach ($data as $v){
            $this->Permission->create();
            $data['Permission']['name'] = $v;
            
            if(!$this->Permission->save($data)){
                $msg = 'Erro ao adicionar funcionalidade(s). Favor tentar novamente.';
                $error = 1;
                break;
            }
        }
        
        if ($error == 0){
            echo json_encode(compact('error', 'msg'));
        }
    }

    public function edit($id = null){
        $this->Permission->id = $id;
        if (!$this->Permission->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Permission->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            // CARREGA DADOS DO REGISTRO
            $this->request->data = $this->Permission->read(null, $id);
        }
    }
    
    public function checar() {
        // PEGA CONTROLLER E ACTIONS DO SISTEMA
        $dados = $this->ControllerList->get();
        
        // PEGA CONTROLLER E ACTIONS CADASTRADAS
        $aux = $this->Permission->find('list');
        
        $remover = array();
        foreach($aux as $v){
            $arr = explode('.',$v);
            $controller = current($arr);
            $action = end($arr);
            $remover[$controller][] = $action;
        }
        
        // REMOVE CONTROLLER E ACTIONS QUE JÁ ESTÃO CADASTRADAS
        foreach($dados as $controller => $v){
            $actions = array_flip($remover[$controller]);
            foreach ($v as $k => $action){
                if (isset($actions[$action])){
                    unset($dados[$controller][$k]);
                }
            }
            if (count($dados[$controller]) == 0){
                unset($dados[$controller]);
            }
        }
        
        // ENVIA DADOS PARA VIEW
        $this->set(compact('dados'));
	}
    
    public function delete($id = null) {
        parent::_delete($id);
    }
}
