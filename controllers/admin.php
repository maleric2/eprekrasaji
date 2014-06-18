<?php

class admin extends Controller {

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

    function index() {
        $pages = array('admin/header', 'admin/footer');
        $this->view->advRender($pages);
    }

    //action=null,change,delete,insert,details(view)
    function korisnici($action = NULL, $korIme = NULL) {
        require 'models/korisnici_model.php';
        $korisnici = new Korisnici_Model();
        $this->view->korisnici = $korisnici->getAllUsersInfo();
        /* CHANGE*/
        if ($action == "change") {
            if(!$korIme)header('location:' . URL . 'error/');
            else if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
                $this->view->user = $korisnici->getUserInfo($korIme);
                $pages = array('admin/header', 'crud/korisnici_change', 'admin/footer');
            } else {
                header('location:' . URL . 'error/other/2');
            }
            /* INSERT NOT DONE */
        } else if ($action == "insert") {
            $pages = array('admin/header', 'crud/prekrsaji_insert', 'admin/footer');
            /* DETAILS */
        } else if ($action == "details") {
            if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
                $this->view->user = $korisnici->getUserInfo($korIme);
                $pages = array('admin/header', 'crud/korisnici_details', 'admin/footer');
            } else {
                header('location:' . URL . 'error/other/2');
            }
            
        } else if ($action == NULL)
            $pages = array('admin/header', 'crud/korisnici', 'admin/footer');
        else
            header('location:' . URL . 'error');

        $this->view->advRender($pages);
    }
    /*function testquery(){
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        $prekrsaji->query("SELECT * FROM ? WHERE oib=?", array("korisnici","12"));
    }*/
    //action=null,change,delete,insert,details(view)
    function prekrsaji($action = NULL, $id = NULL) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        require 'models/korisnici_model.php';
        $korisnici = new Korisnici_Model();

        $this->view->prekrsaji = $prekrsaji->getAllPrekrsaji();
        $this->view->policajci = $korisnici->getAllModUsers();
        $this->view->korisnici = $korisnici->getAllUsersInfo();
        $this->view->kategorije = $prekrsaji->getAllActiveKategorije();
        

        if ($action == "change") {
            foreach ($this->view->prekrsaji as $value) {
                if ($id == $value["id_prekrsaji"]) {
                    $this->view->prekrsaj = $value;
                    $this->view->korisniciPrekrsaja = $prekrsaji->getPrekrsajiUsers($id);
                    $this->view->datoteke = $prekrsaji->getDatoteke($id);
                }
            }
            $pages = array('admin/header', 'crud/prekrsaji_change', 'admin/footer');
        } else if ($action == "insert") {
            $pages = array('admin/header', 'crud/prekrsaji_insert', 'admin/footer');
        } else if ($action == "details") {
            foreach ($this->view->prekrsaji as $value) {
                if ($id == $value["id_prekrsaji"]) {
                    $this->view->prekrsaj = $value;
                    $this->view->korisniciPrekrsaja = $prekrsaji->getPrekrsajiUsers($id);
                    $this->view->datoteke = $prekrsaji->getDatoteke($id);
                }
            }
            $pages = array('admin/header', 'crud/prekrsaji_details', 'admin/footer');
        } else if ($action == NULL)
            $pages = array('admin/header', 'crud/prekrsaji', 'admin/footer');
        else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }

    //id of prekrsaj
    function slike($id = NULL) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        if ($id == NULL) {
            $this->view->datoteke = $prekrsaji->getAllDatoteke();
            $pages = array('admin/header', 'crud/slike', 'admin/footer');
        }
        /* ako je prosljedjen broj */ else if (is_numeric($id)) {
            $this->view->datoteke = $prekrsaji->getDatoteke($id);
            $this->view->prekrsaj['id_prekrsaja'] = $id;
            $pages = array('admin/header', 'crud/slike', 'admin/footer');
        } else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }

}
