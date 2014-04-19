<?php
/**
 * CakePHP FuncionalidadesController
 * @author Gustavo Cardoso
 */
class FuncionalidadesController extends AppController {
    
    public function index() {   
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->Funcionalidade->recursive = 1;
        
        //FILTRO INICIAL
        //$conditions = array('conditions'=>array(''));
        
        // PEGA FUNCIONALIDADES CADASTRADAS
        $dados = $this->Funcionalidade->find('all', $options);
        
        // ESTILIZA LINHA DA GRID
        foreach($dados as $k => $v){
            if ($v['Funcionalidade']['ativo'] != 'Sim') {
                $dados[$k]['Funcionalidade']['style'] = 'background-color: #F2C9CA';
            }
        }
        
        // PERMISSÕES NÃO VINCULADAS
        $this->set('permissoesNaoVinculadas',$this->Funcionalidade->findPermissoesNaoVinculadas());
        
        // SE AJAX RENDERIZA COMO JSON
        if($this->request->is('ajax')){ 
            // PREPARA DADOS
            foreach($dados as $k => $v){
                $records[] = $v['Funcionalidade'];
            }

            // CALCULA O TOTAL DE REGISTROS
            $total = count($dados);
            
            // ENVIA DADOS PARA A VIEW
            echo json_encode(compact('total','records'));
            exit;
        }
    }
    
    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Funcionalidade->save($this->request->data)) {
                if($this->request->is('ajax')){ 
                    $error = 0;
                    $url = Router::url(array('action'=>'index'), true);
                    echo json_encode(compact('error','url'));
                    exit;
                } else {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        
        // PEGA LISTA DE PERMISSÕES
        $this->set('optionsPermissions', $this->Funcionalidade->Permission->find('list'));
        
        // PEGA LISTA DE MÓDULOS
        $this->set('modulos', $this->Funcionalidade->Modulo->find('list', array('conditions'=>array('active'=>1))));
    }
    
    public function edit($id = null) {
        $this->Funcionalidade->id = $id;
        if (!$this->Funcionalidade->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Funcionalidade']['id'] = $id;
            if ($this->Funcionalidade->save($this->request->data)){
                if($this->request->is('ajax')){ 
                    $error = 0;
                    $url = Router::url(array('action'=>'index'), true);
                    echo json_encode(compact('error','url'));
                    exit;
                } else {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->request->data = $this->Funcionalidade->read(null, $id);
            $aux = array();
            foreach($this->request->data['Permission'] as $v){
                $aux[] = $v['id'];
            }
            $this->set('selectedPermissions', $aux);
        }
        
        // PEGA LISTA DE PERMISSÕES
        $this->set('optionsPermissions', $this->Funcionalidade->Permission->find('list'));
        
        // PEGA LISTA DE MÓDULOS
        $this->set('modulos', $this->Funcionalidade->Modulo->find('list', array('conditions'=>array('active'=>1))));
    }
    
    public function delete($id = null) {
        parent::_delete($id);
    }
}
