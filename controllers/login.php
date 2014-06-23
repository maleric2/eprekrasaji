<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();

    }
    
    function index() {
        //require 'models/login_model.php';
        //$model=new Login_Model();
        
        $this->view->render('login/index');
    }
    function run(){
        $this->model->run();
    }

    function logout(){
        Session::init();
        $logged = Session::get('loggedIn');
        Session::destroy();
        header('location:'.URL.'login');
        setcookie("user", "", -3600,"/");//coockie odjava
        exit;
    }
    function djelatnici($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "zupanija") {
            $uprave = $prekrsaji->query("SELECT p.naziv as naziv, z.naziv as zupanija, p.id_policijske_uprave FROM policijske_uprave p JOIN zupanije z ON p.zupanije_id_zupanije=z.id_zupanije WHERE z.naziv = ?", array($id));
            print_r(json_encode($uprave));
        } else if ($action == "uprava") {
            $uprave = $prekrsaji->query("SELECT * FROM korisnici k JOIN policijske_uprave p ON k.id_policijske_uprave = p.id_policijske_uprave WHERE id_tipKorisnika = 2 and p.id_policijske_uprave = ?", array($id));
            print_r(json_encode($uprave));
        }
    }   
}