<?php

class Controller {

    function __construct() {
        $this->view=new View();
    }
    
    public function loadModel($name) {
        $path = 'models/' . $name . '_model.php';
        if(file_exists($path)){
            require 'models/' . $name . '_model.php';
            $modelName= $name . '_Model';
            $this->model = new $modelName();
            $this->view->putanja.=$this->model->putanja;
        }
        
    }
    public function getObject($source){
        $items=null;
        foreach ($source as $key=>$value) {
            $items->$key=$value;
        }
        return $items;
    }
    public static function setCookie($key, $value, $time){
       setcookie($key, $value, $time, '/');
    }
    public static function getCookie($key){
       return $_COOKIE[$key];
    }

}