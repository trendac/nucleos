<?php
/**
 * CakePHP ModulosController
 * @author Gustavo Cardoso
 */
class ModulosController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function index() {   
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->Modulo->recursive = 1;
        
        // PEGA MÓDULOS CADASTRADOS
        $dados = $this->Modulo->find('all', $options);
        
        // ESTILIZA LINHA DA GRID
        foreach($dados as $k => $v){
            if ($v['Modulo']['ativo'] != 'Sim') {
                $dados[$k]['Modulo']['style'] = 'background-color: #F2C9CA';
            }
        }

        // SE AJAX RENDERIZA COMO JSON
        if($this->request->is('ajax')){ 
            // PREPARA DADOS
            foreach($dados as $k => $v){
                $records[] = $v['Modulo'];
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
            if ($this->Modulo->save($this->request->data)) {
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
        $this->set('optionsFuncionalidades', $this->Modulo->Funcionalidade->find('list', array('conditions'=>array('Funcionalidade.active'=>1))));
    }
    
    public function edit($id = null) {
        $this->Modulo->id = $id;
        if (!$this->Modulo->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Modulo']['id'] = $id;
            if ($this->Modulo->save($this->request->data)) {
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
            $this->request->data = $this->Modulo->read(null, $id);
            $aux = array();
            foreach($this->request->data['Funcionalidade'] as $v){
                $aux[] = $v['id'];
            }
            $this->set('selectedFuncionalidades', $aux);
        }
        
        // PEGA LISTA DE FUNCIONALIDADES
        $this->set('optionsFuncionalidades', $this->Modulo->Funcionalidade->find('list', array('conditions'=>array('OR'=>array('Funcionalidade.active'=>1,'Funcionalidade.id IN ('.implode(',',$aux).')')))));
    }
    
    public function delete($id = null) {
        parent::_delete($id);
    }
}
