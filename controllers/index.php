<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        $pages = array('container', 'crud/public', 'footer');
        $this->view->uprave = $prekrsaji->query("SELECT p.id_policijske_uprave, p.naziv as uprava, z.naziv as zupanija FROM policijske_uprave p JOIN zupanije z ON p.zupanije_id_zupanije=z.id_zupanije");
        $this->view->zupanije = $prekrsaji->query("SELECT * FROM zupanije");
        $this->view->advRender($pages);
    }

    

}
