<?php
/**
 * CakePHP GroupsController
 * @author Gustavo Cardoso
 */
class GroupsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function index() {   
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->Group->recursive = 1;
        
        //FILTRO INICIAL
        //$conditions = array('conditions'=>array(''));
        
        // PEGA FUNCIONALIDADES CADASTRADAS
        $dados = $this->Group->find('all', $options);
        
        // ESTILIZA LINHA DA GRID
        foreach($dados as $k => $v){
            if ($v['Group']['ativo'] != 'Sim') {
                $dados[$k]['Group']['style'] = 'background-color: #F2C9CA';
            }
        }
        
        // GRUPOS SEM FUNCIONALIDADES
        $this->set('gruposSemFuncionalidades',$this->Group->gruposSemFunctionalidades());

        // SE AJAX RENDERIZA COMO JSON
        if($this->request->is('ajax')){ 
            // PREPARA DADOS
            foreach($dados as $k => $v){
                $records[] = $v['Group'];
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
            if ($this->Group->save($this->request->data)) {
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
        
        // PEGA LISTA DE FUNCIONALIDADES
        $this->set('optionsFuncionalidades', $this->Group->Funcionalidade->find('list', array('conditions'=>array('Funcionalidade.active'=>1))));
    }
    
    public function edit($id = null) {
        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Group']['id'] = $id;
            if ($this->Group->save($this->request->data)) {
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
        } else {
            $this->request->data = $this->Group->read(null, $id);
            $aux = array();
            foreach($this->request->data['Funcionalidade'] as $v){
                $aux[] = $v['id'];
            }
            $this->set('selectedFuncionalidades', $aux);
        }
        
        // PEGA LISTA DE FUNCIONALIDADES
        $this->set('optionsFuncionalidades', $this->Group->Funcionalidade->find('list', array('conditions'=>array('Funcionalidade.active'=>1))));
    }
    
    public function delete($id = null) {
        parent::_delete($id);
    }
}
