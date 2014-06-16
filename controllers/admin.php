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
    //action=null,change,delete,insert,details(view)
    function prekrsaji($action=NULL, $id=NULL){
        require 'models/prekrsaji_model.php';
        $prekrsaji=new Prekrsaji_Model();
        require 'models/korisnici_model.php';
        $korisnici=new Korisnici_Model();
        
        $this->view->prekrsaji=$prekrsaji->getAllPrekrsaji();
        $this->view->policajci=$korisnici->getAllModUsers();
        $this->view->kategorije=$prekrsaji->getAllActiveKategorije();
        
        if($action=="change"){
            foreach ($this->view->prekrsaji as $value) {
                if($id==$value["id_prekrsaji"]){
                    $this->view->prekrsaj=$value;
                    $this->view->datoteke=$prekrsaji->getDatoteke($id);
                }
            }
            $pages=array('admin/header','crud/prekrsaji_change', 'admin/footer');
        }
        else if($action=="insert"){
            $pages=array('admin/header','crud/prekrsaji_insert', 'admin/footer');  
        }
        else if($action=="details"){
            foreach ($this->view->prekrsaji as $value) {
                if($id==$value["id_prekrsaji"]){
                    $this->view->prekrsaj=$value;
                    $this->view->datoteke=$prekrsaji->getDatoteke($id);
                }
            }
            $pages=array('admin/header','crud/prekrsaji_view', 'admin/footer');  
        }
        else if($action==NULL)
            $pages=array('admin/header','crud/prekrsaji', 'admin/footer');
        else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }
    //id of prekrsaj
    function slike($id=NULL){
        require 'models/prekrsaji_model.php';
        $prekrsaji=new Prekrsaji_Model();
        
        if($id==NULL){
            $this->view->datoteke=$prekrsaji->getAllDatoteke();
            $pages=array('admin/header','crud/slike', 'admin/footer');
        }
        /* ako je prosljedjen broj*/
        else if(is_numeric($id)){
            $this->view->datoteke=$prekrsaji->getDatoteke($id);
            $this->view->prekrsaj['id_prekrsaja']=$id;
            $pages=array('admin/header','crud/slike', 'admin/footer');
        }
        else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }
}