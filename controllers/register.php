<?php

class Register extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->view->render('register/index');
    }
    function run($admin=1, $json=0, $regitems=0){
        if($regitems!=0)$regitems=$this->getObject($_POST);
        $response=new stdClass();
        /*echo "<pre>";
        var_dump($regitems);
        echo "</pre>";*/
        //CAPATCHA
        if(!$admin){
            require_once('./public/recaptcha/recaptchalib.php');
            $privatekey = "6LeWNPMSAAAAAE-xqVR0WXUtLHt9EtayqYdp27RQ";
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) 
                header('location:' . URL . 'error/register/6');

            if($this->validation($regitems)) {
                $this->model->run($regitems);
            }
        }
        elseif($json){
            require 'models/korisnici_model.php';
                $korisnici=new Korisnici_Model();
                if($korisnici->insertUser($regitems)){
                    $response->ok=true;
                    if($json==1)return $response;
                }
                 else{
                    $response->ok=false;
                    $response->error=URL . 'register';
                    //header('location:' . URL . 'register');
                      if($json==1)return $response;
                }   
            
        }
        elseif($this->validation($regitems)==true) {
                require 'models/korisnici_model.php';
                $korisnici=new Korisnici_Model();
                if($korisnici->insertUser($regitems)){
                    return true;
                }
                else{
                    header('location:' . URL . 'register');
                     return false;
                }
        }
    }
    function runJson(){
        $response=$this->run(1,1,$this->getObject($_POST));
        echo json_encode($response);
        //echo $response;
    }
    function update(){
        $regitems=$this->getObject($_POST);

        if($this->validation($regitems, 1)) {
            $this->model->update($regitems);
        }
    }
    function validation($regitems, $type=0, $json=0){
         //dali su svi podaci uneseni
        if (!$regitems->pass || !$regitems->ime 
                || !$regitems->prezime || !$regitems->oib || !$regitems->email
                || !$regitems->korime) {
            header('location:' . URL . 'error/register/2');
            if($json==1) return URL . 'error/register/2';
            return false;
        }//password
        elseif ($regitems->pass != $regitems->pass2 && !$type) {
            header('location:' . URL . 'error/register/1');
            if($json==1) return URL . 'error/register/1';
            return false;
        }//ispravan mail
        elseif (!filter_var($regitems->email, FILTER_VALIDATE_EMAIL)) {
            header('location:' . URL . 'error/register/3');
            if($json==1) return URL . 'error/register/3';
            return false;
        }//ime dali sadrzi samo slova, i jesu li sva slova mala
        elseif (!ctype_alpha($regitems->ime) || ctype_lower($regitems->ime)) {
                header('location:' . URL . 'error/register/4');
                if($json==1) return URL . 'error/register/4';
                return false;
        }
        elseif (!ctype_alpha($regitems->prezime) || ctype_lower($regitems->prezime)) {
                header('location:' . URL . 'error/register/5');
                if($json==1) return URL . 'error/register/5';
                return false;
        }
        else
            return true;
    }
    function check($param, $name){
        $item->item=$param;
        $item->value=$name;
        if($this->model->check($item)){
            echo "TRUE";
        }
        else echo "FALSE";
    }
    
    function success(){
        $this->view->render('register/success');     
    }

    //Activate from email
    function activate($korIme) {
        require 'models/korisnici_model.php';
        $korisnici_model = new Korisnici_Model();     
        $this->userToActivate=$korisnici_model->getUserInfo($korIme);
        $this->userToActivate['status']=2;
        $user=$this->getObject($this->userToActivate);

        $korisnici_model->updateUser($user);
        header('location:'.URL.'login/logout');
    }
}

