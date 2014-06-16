<?php

class Prekrsaji extends Controller {

    function __construct() {
        parent::__construct();

        //redirekt automatski
        Session::init();
        $logged = Session::get('loggedIn');
        $this->view->currentUser = Session::get('user');
        if ($logged == false) {
            Session::destroy();
            header('location:' . URL . '/login');
            exit;
        }
    }

    function index( $korime=NULL) {
        Session::init();
        if($korime==null)$korime=$this->view->currentUser["korIme"];

        $this->view->prekrsaji = $this->model->getUserPrekrsaji($korime);
        $this->view->render('crud/prekrsaji');
    }

    function details($korIme) {

        if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
            $this->view->user = $this->model->getUserInfo($korIme);
            $this->view->render('crud/korisnici_details');
        } else {
            header('location:' . URL . 'error/other/2');
        }
    }

    function change($korIme) {

        if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
            $this->view->user = $this->model->getUserInfo($korIme);
            $this->view->render('crud/korisnici_change');
        } else {
            header('location:' . URL . 'error/other/2');
        }
    }

    //Activate from korisnici
    function activate($korIme) {

        if ($this->view->currentUser["id_tipKorisnika"] > 1) {
            $this->userToActivate = $this->model->getUserInfo($korIme);
            $this->userToActivate['status'] = 2;
            $this->userToActivate['obrisan'] = 0;
            $user = $this->getObject($this->userToActivate);
            $this->model->updateUser($user);
        } else {
            header('location:' . URL . 'error/other/3');
        }
    }

    function delete($korIme) {

        if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
            $this->userToDelete = $this->model->getUserInfo($korIme);
            $this->userToDelete['status'] = 1;
            $this->userToDelete['obrisan'] = 1;
            $user = $this->getObject($this->userToDelete);
            $this->model->updateUser($user);
            if ($this->view->currentUser["korIme"] === $korIme)
                header('location:' . URL . 'login/logout');
        }
        else {
            header('location:' . URL . 'error/other/3');
        }
    }

    function update() {

        $user = $this->getObject($_POST);
        //var_dump($user);

        if ($this->validation($user, 2)) {
            require 'models/prekrsaji_model.php';
            $prekrsaji = new Prekrsaji_Model();
            $userOld = $this->model->getUserInfo($user->korime);
            if($userOld["id_profilna_slika"]){
                $prekrsaji->deleteDatoteke($userOld["id_profilna_slika"]);               
            }
   
            $datoteka = $this->insertSlikaInDir($_FILES, $user->korime);
            
            $user->id_profilna_slika = $prekrsaji->insertDatoteke($datoteka);
            //var_dump($user->id_profilna_slika);
            if ($this->model->updateUser($user))
                header('location:' . URL . 'admin/korisnici');
            else
                header('location:' . URL . 'error');
        }
    }

    /* INSERT POJEDINACNE SLIKE (PROFILE PICTURE) */
    function insertSlikaInDir($files, $path) {
        $allowed = array('png', 'jpg', 'gif', 'zip');
        $datoteka = new stdClass();
        $datoteka->naziv = NULL;
        $datoteka->putanja = NULL;
        if (isset($files['picture']) && $files['picture']['error'] == 0) {
            $extension = pathinfo($files['picture']['name'], PATHINFO_EXTENSION);
            $datoteka->naziv = $files['picture']['name'];

            if (!in_array(strtolower($extension), $allowed)) {
                header('location:' . URL . 'error');
            }
            if (!file_exists('public/img/' . $path)) {
                mkdir('public/img/' . $path, 0777, true);
            }
            if (move_uploaded_file($files['picture']['tmp_name'], 'public/img/' . $path . '/' . $files['picture']['name'])) {
                $datoteka->putanja = 'public/img/' . $path . '/' . $files['picture']['name'];
            }
        }
        return $datoteka;
    }

    function validation($regitems, $type = 0, $json = 0) {
        //dali su svi podaci uneseni
        if ($type < 2)
            if (!$regitems->pass || !$regitems->ime || !$regitems->prezime || !$regitems->oib || !$regitems->email || !$regitems->korime) {
                header('location:' . URL . 'error/register/2');
                if ($json == 1)
                    return URL . 'error/register/2';
                return false;
            }

        if ($type < 2) //password
            if ($regitems->pass != $regitems->pass2 && !$type) {
                header('location:' . URL . 'error/register/1');
                if ($json == 1)
                    return URL . 'error/register/1';
                return false;
            }
        if ($type >= 2) {//ispravan mail
            if (!filter_var($regitems->email, FILTER_VALIDATE_EMAIL)) {
                header('location:' . URL . 'error/register/3');
                if ($json == 1)
                    return URL . 'error/register/3';
                return false;
            }//ime dali sadrzi samo slova, i jesu li sva slova mala
            elseif (!ctype_alpha($regitems->ime) || ctype_lower($regitems->ime)) {
                header('location:' . URL . 'error/register/4');
                if ($json == 1)
                    return URL . 'error/register/4';
                return false;
            }
            elseif (!ctype_alpha($regitems->prezime) || ctype_lower($regitems->prezime)) {
                header('location:' . URL . 'error/register/5');
                if ($json == 1)
                    return URL . 'error/register/5';
                return false;
            }
        }
        return true;
    }

}
