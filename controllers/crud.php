<?php

class crud extends Controller{

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
        
   
        if($action=="change"){
            $prekrsaj= $this->getObject($_POST);
            $prekrsaji->update($prekrsaj);
            header('location:' . URL . 'admin/prekrsaji');
        }
        else if($action=="delete"){
            if($prekrsaji->delete($id))
                header('location:' . URL . 'admin/prekrsaji');
            else {
                header('location:' . URL . 'error');
            }
        }
        else if($action=="insert"){
            $prekrsaj= $this->getObject($_POST);
            $prekrsaj->vrijeme_prekrsaja=strtotime($prekrsaj->datum . ' ' . $prekrsaj->vrijeme);
            $prekrsaji->insert($prekrsaj);
            $pages=array('admin/header','crud/prekrsaji', 'admin/footer');
        }
        else if($action==NULL)
            header('location:' . URL . 'admin/prekrsaji');
        else
            header('location:' . URL . 'error');
        
        $this->view->advRender($pages);
    }
}