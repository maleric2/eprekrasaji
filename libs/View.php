<?php

class View {

    function __construct() {
        //echo 'This is the view <br\>';
    }
    public function render($name, $noInclude = false){
        
        if ($noInclude == true) {
            require 'views/' . $name . '.php';
        }
        else{
            require 'views/header.php';
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
        
    }
    public function advRender($name){
       require 'views/header.php';
       foreach ($name as $value) {
           require 'views/' . $value . '.php';
       }     
       require 'views/footer.php';
        
    }
}

