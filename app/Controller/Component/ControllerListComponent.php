<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP controller_list
 * @author Gustavo Cardoso
 */
class ControllerListComponent extends Component {
    public function get() {
        // PEGA TODAS OS CONTROLLERS EXISTENTES
        $controllerClasses = App::objects('controller');
        
        // PARA CADA CONTROLLER RELACIONA OS MÉTODOS
        foreach($controllerClasses as $controller) {
            // REMOVE A PALAVRA CONTROLLER DA STRING
            $controller = str_replace('Controller', '', $controller);
            
            // REMOVE O CONTROLLER APP
            if ($controller != 'App') { 
                // IMPORTA O CONTROLLER
                App::import('Controller', $controller);
                $className = $controller;
                
                // PEGA OS MÉTODOS DO CONTROLLER
                $actions = get_class_methods($className.'Controller');
                
                foreach($actions as $k => $v) {
                    if ($v{0} == '_') {
                        unset($actions[$k]);
                    }
                }
                
                $parentActions = get_class_methods('AppController');
                $controllers[strtolower($controller)] = array_diff($actions, $parentActions);
            }
        }
		     
        return $controllers;  
    }
}
