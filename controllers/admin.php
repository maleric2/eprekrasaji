<?php

class admin extends Controller{

    function __construct() {
        parent::__construct();
        //redirekt automatski
        Session::init();
        $logged = Session::get('loggedIn');
        $this->view->currentUser=Session::get('user');
        if($logged == false){
            Session::destroy();
            header('location:'.URL.'/login');
            exit;
        }
    }
    function index() {
        $pages=array('admin/header', 'admin/footer');
        $this->view->advRender($pages);
    }
    
    function korisnici(){
        require 'models/korisnici_model.php';
        $korisnici=new Korisnici_Model();
        $this->view->korisnici=$korisnici->getAllUsersInfo();
        //$this->view->render('korisnici/index');
        $pages=array('admin/header','korisnici/index', 'admin/footer');
        $this->view->advRender($pages);
        
    }
    //action=null,change,delete,insert
    function prekrsaji($action=NULL, $id=NULL){
        require 'models/prekrsaji_model.php';
        $prekrsaji=new Prekrsaji_Model();
        $this->view->prekrsaji=$prekrsaji->getAllPrekrsaji();
        if($action=="change"){
            foreach ($this->view->prekrsaji as $value) {
                if($id==$value["id_prekrsaji"]){
                    $this->view->prekrsaj=$value;
                }
            }
            $pages=array('admin/header','crud/prekrsaji_change', 'admin/footer');
        }
        else if($action=="insert"){
            $pages=array('admin/header','crud/prekrsaji_insert', 'admin/footer');
            require 'models/korisnici_model.php';
            $korisnici=new Korisnici_Model();
            $this->view->policajci=$korisnici->getAllModUsers();
            $this->view->kategorije=$prekrsaji->getAllActiveKategorije();
            
        }
        else if($action==NULL)
            $pages=array('admin/header','crud/prekrsaji', 'admin/footer');
        else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }
}