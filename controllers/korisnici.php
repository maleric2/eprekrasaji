<?php

class Korisnici extends Controller {

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
        Session::init();
        $this->view->korisnici=$this->model->getAllUsersInfo();
        $this->view->render('korisnici/index');
                
    }
    
    function details($korIme) {

        if($this->view->currentUser["id_tipKorisnika"]>1 || $this->view->currentUser["korIme"]===$korIme){
            $this->view->user=$this->model->getUserInfo($korIme);
            $this->view->render('korisnici/details');
        }
        else{
            header('location:'.URL.'error/other/2');
        }
    }
    
    function change($korIme) {

        if($this->view->currentUser["id_tipKorisnika"]>1 || $this->view->currentUser["korIme"]===$korIme){
            $this->view->user=$this->model->getUserInfo($korIme);
            $this->view->render('korisnici/change');
        }
        else{
            header('location:'.URL.'error/other/2');
        }
    }
    //Activate from korisnici
    function activate($korIme) {

        if($this->view->currentUser["id_tipKorisnika"]>1){
            $this->userToActivate=$this->model->getUserInfo($korIme);
            $this->userToActivate['status']=2;
            $this->userToActivate['obrisan']=0;
            $user=$this->getObject($this->userToActivate);
            $this->model->updateUser($user);
        }
        else{
            header('location:'.URL.'error/other/3');
        }
    }
    
    function delete($korIme) {

        if($this->view->currentUser["id_tipKorisnika"]>1 || $this->view->currentUser["korIme"]===$korIme){
            $this->userToDelete=$this->model->getUserInfo($korIme);
            $this->userToDelete['status']=1;
            $this->userToDelete['obrisan']=1;
            $user=$this->getObject($this->userToDelete); 
            $this->model->updateUser($user);
            if($this->view->currentUser["korIme"]===$korIme)    
                header('location:'.URL.'login/logout');
        }
        else{
            header('location:'.URL.'error/other/3');
        }
    }
}

