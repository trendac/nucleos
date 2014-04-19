<?php 

class DateFormatterBehavior extends ModelBehavior {
    //Our  format
    var $dateFormat = 'd/m/Y';
    //datebase Format
    var $databaseFormat = 'Y-m-d';

//    function setup(Model $model, $config = array()) {
//        $this->model = $model;
//    }

    function _changeDateFormat($date = null, $dateFormat){
        return date($dateFormat, strtotime($date));
    }

    //This function search an array to get a date or datetime field. 
    function _changeDate($queryDataConditions , $dateFormat, $model){
        $this->model = $model;
        if ($queryDataConditions != null){
            foreach($queryDataConditions as $key => $value){
                if(is_array($value)){
                    $queryDataConditions[$key] = $this->_changeDate($value,$dateFormat, $model);
                } else {
                    $columns = $this->model->getColumnTypes();
                    //sacamos las columnas que no queremos
                    foreach($columns as $column => $type){
                        if(($type != 'date') && ($type != 'datetime')) unset($columns[$column]);
                    }
                    
                    //we look for date or datetime fields on database model  
                    foreach($columns as $column => $type){
                        if(strstr($key,$column)){
                            if($type == 'datetime') $queryDataConditions[$key] = $this->_changeDateFormat($value,$dateFormat.' H:i:s ');
                            if($type == 'date') $queryDataConditions[$key] = $this->_changeDateFormat($value,$dateFormat);
                        }
                    }

                }
            }
        }
        return $queryDataConditions;
    }

    function beforeFind(Model $model, $query){
        $query['conditions'] = $this->_changeDate($query['conditions'] , $this->databaseFormat, $model);
        return $query;
    }

    function afterFind(Model $model, $results, $primary = false){
        $results = $this->_changeDate($results, $this->dateFormat, $model);
        return $results;
    }

    function beforeSave(Model $model, $options = array()) {
        $model->data = $this->_changeDate($model->data, $this->databaseFormat, $model);
        return true;
    }
}