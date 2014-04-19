<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    var $actsAs = array(
        'DateFormatter', 
        //'Containable'
    );
    
    public function beforeFind($query) {
        // CRIA CAMPO VIRTUAL PARA SER UTILIZADO PELO W2UI
        $this->virtualFields['recid'] = $this->name.'.'.$this->primaryKey;
        parent::beforeFind($query);
    }
    
    public function _extractFieldsHABTM($data, $id, $chave, $lookup){
        $dados = array();
        
        if (!empty($data)){
            foreach($data as $k => $v){
                $dados[$k][$chave] = $id;
                $dados[$k][$lookup] = $v;
            }
        }
        
        return $dados;
    }
}
