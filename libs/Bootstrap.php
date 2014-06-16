<?php

class Bootstrap {

    function __construct() {
        
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        //print_r($url);
        if(empty($url[0])){
            require 'controllers/index.php';
            $controller=new Index();
            $controller->index();
            return false;
        }

        $file= 'controllers/' . $url[0] . '.php';
        if(file_exists($file)){
            require $file;
        }
        else{
            $this->error();
            return false;
        }
        $controller = new $url[0];
        $controller->loadModel($url[0]);
        
        //Ako je unesena metoda npr help/other
        /*3 parametra max*/
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                 if (isset($url[4])) $controller->{$url[1]}($url[2],$url[3],$url[4]);   
                 else if (isset($url[3])) $controller->{$url[1]}($url[2],$url[3]);
                 else $controller->{$url[1]}($url[2]);
            } else {
		$this->error();
            }
	}else{
            if (isset($url[1])) {
		if (method_exists($controller, $url[1])) {
			$controller->{$url[1]}();
		} else {
			$this->error();
		}
            } else {
		$controller->index();
            }
        }
        
    }
    function error() {
	require 'controllers/error.php';
	$controller = new Error();
	$controller->index();
	return false;
    }

}

