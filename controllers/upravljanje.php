<?php

Abstract class Upravljanje extends Controller {

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

    //action=null,change,delete,insert,details(view)
    function korisnici($action = NULL, $korIme = NULL) {
        require_once 'models/korisnici_model.php';
        $korisnici = new Korisnici_Model();
        $this->view->korisnici = $korisnici->getAllUsersInfo();
        $this->view->uprave = $korisnici->query("SELECT * FROM policijske_uprave ");
        /* CHANGE */
        if ($action == "change") {
            if (!$korIme)
                header('location:' . URL . 'korisnici');
            else if ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
                $this->view->user = $korisnici->getUserInfo($korIme);
                $this->view->tipKorisnika = $korisnici->query("SELECT * FROM tipKorisnika");
                if ($this->nameOfFunction == "admin")
                    $pages = array('admin/header', 'crud/korisnici_change', 'admin/footer');
                else
                    $pages = array('container', 'crud/korisnici_change', 'footer');
            } else {
                header('location:' . URL . 'error/other/2');
            }
            /* INSERT NOT DONE */
        } else if ($action == "insert") {
            $pages = array('admin/header', 'crud/prekrsaji_insert', 'admin/footer');
            /* DETAILS */
        } else if ($action == "details") {
            if (!$korIme)
                header('location:' . URL . 'korisnici');
            elseif ($this->view->currentUser["id_tipKorisnika"] > 1 || $this->view->currentUser["korIme"] === $korIme) {
                $this->view->user = $korisnici->getUserInfo($korIme);
                $this->view->tipKorisnika = $korisnici->query("SELECT * FROM tipKorisnika");
                if ($this->nameOfFunction == "admin")
                    $pages = array('admin/header', 'crud/korisnici_details', 'admin/footer');
                else
                    $pages = array('container', 'crud/korisnici_details', 'footer');
            } else {
                header('location:' . URL . 'error/other/2');
            }
        } else if ($action == NULL) {
            if ($this->view->currentUser["id_tipKorisnika"] < 2 || $this->view->currentUser["korIme"] === $korIme)
                header('location:' . URL . 'korisnici/korisnici/details/' . $this->view->currentUser["korIme"]);
            else
                $pages = array('admin/header', 'crud/korisnici', 'admin/footer');
        } else
            header('location:' . URL . 'error');

        $this->view->advRender($pages);
    }

    /* function testquery(){
      require 'models/prekrsaji_model.php';
      $prekrsaji = new Prekrsaji_Model();
      $prekrsaji->query("SELECT * FROM ? WHERE oib=?", array("korisnici","12"));
      } */

    //action=null,change,delete,insert,details(view)
    function prekrsaji($action = NULL, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        require_once 'models/korisnici_model.php';
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
                    $this->view->adresa = $prekrsaji->query("SELECT * FROM korisnici k JOIN zupanije z on k.id_zupanije=z.id_zupanije WHERE oib = ?", array($this->view->prekrsaj['policajac_oib_policajac']));
                    $this->view->korisniciPrekrsaja = $prekrsaji->getPrekrsajiUsers($id);
                    $this->view->datoteke = $prekrsaji->getDatoteke($id);
                }
            }
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/prekrsaji_details', 'admin/footer');
            else
                $pages = array('container', 'crud/prekrsaji_details', 'footer');
        } else if ($action == NULL)
            $pages = array('admin/header', 'crud/prekrsaji', 'admin/footer');
        else
            header('location:' . URL . 'error');
        $this->view->advRender($pages);
    }

    //function insertSlikaInDir($files, $path);
    //id of prekrsaj
    function slike($id = NULL) {
        require_once 'models/prekrsaji_model.php';
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

    function uprave($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        if ($this->nameOfFunction == "admin")
            $pages = array('admin/header', 'crud/uprave', 'admin/footer');
        else
            $pages = array('container', 'crud/uprave', 'footer');

        $this->view->uprave = $prekrsaji->query("SELECT p.id_policijske_uprave, p.naziv as uprava, z.naziv as zupanija FROM policijske_uprave p JOIN zupanije z ON p.zupanije_id_zupanije=z.id_zupanije");
        $this->view->zupanije = $prekrsaji->query("SELECT * FROM zupanije");
        $this->view->advRender($pages);
    }

    function zupanije($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        if ($this->nameOfFunction == "admin")
            $pages = array('admin/header', 'crud/zupanije', 'admin/footer');
        else
            $pages = array('container', 'crud/uprave', 'footer');

        $this->view->zupanije = $prekrsaji->query("SELECT * FROM zupanije");
        $this->view->advRender($pages);
    }

    function zalbe($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        $this->view->statusZalbe = array("Zaprimljena", "Odbijena", "Prihvaćena");
        if ($action == "insert") {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/zalbe_insert', 'admin/footer');
            else
                $pages = array('container', 'crud/zalbe_insert', 'footer');

            if ($id)
                $this->view->prekrsaj = $prekrsaji->query("SELECT * FROM prekrsaji WHERE id_prekrsaji = ? ", array($id), false);
            else
                $this->view->prekrsaj = $prekrsaji->query("SELECT * FROM prekrsaji");
        }
        else if ($action == "change") {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/zalbe_change', 'admin/footer');
            else
                $pages = array('container', 'crud/zalbe_change', 'footer');
            $this->view->prekrsaj = $prekrsaji->query("SELECT * FROM prekrsaji");
            $this->view->zalba = $prekrsaji->query("SELECT z.naziv,z.opis, z.id_prekrsaji, d.putanja, z.id_zalbe, z.status FROM zalbe z LEFT JOIN datoteke d ON z.dokaz=d.id_datoteke WHERE id_zalbe = ? ", array($id));
            //$this->view->zalba = $prekrsaji->query("SELECT * FROM zalbe WHERE id_zalbe = ? ", array($id));
            if (!$this->view->zalba)
                header('location:' . URL . 'error');
        }
        else if ($id) {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/zalbe', 'admin/footer');
            else
                $pages = array('container', 'crud/zalbe', 'footer');
            $this->view->zalbe = $prekrsaji->query("SELECT * FROM zalbe WHERE id_prekrsaji = ? ", array($id), false);
            $this->view->id_prekrsaj = $id;
        }
        else {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/zalbe', 'admin/footer');
            else
                $pages = array('container', 'crud/zalbe', 'footer');

            if ($this->view->currentUser['id_tipKorisnika'] == 1) {
                //$this->view->zalbe = $prekrsaji->query("SELECT z.naziv as naziv, z.opis as opis, z.status, z.id_prekrsaji, z.id_zalbe FROM zalbe z JOIN prekrsaji p on z.id_prekrsaji=p.id_prekrsaji WHERE id");
                $this->view->zalbe = $prekrsaji->getUsersZalbe($this->view->currentUser['oib']);
                /* SREDIT */
            } else
                $this->view->zalbe = $prekrsaji->query("SELECT * FROM zalbe");
        }
        $this->view->advRender($pages);
    }

    function sustav($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "log") {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/log', 'admin/footer');
            else
                $pages = array('container', 'crud/log', 'footer');
            $this->view->logs = $prekrsaji->query("SELECT * FROM log l JOIN korisnici k ON l.korisnici = k.oib");
        }
        else if ($action == "sesija") {
            if ($this->nameOfFunction == "admin")
                $pages = array('admin/header', 'crud/log', 'admin/footer');
            else
                $pages = array('container', 'crud/log', 'footer');
            $this->view->sesija = $prekrsaji->query("SELECT * FROM sesija s JOIN korisnici k ON s.korisnici_oib = k.oib");
        }
        $this->view->advRender($pages);
    }

    function policajci($action = null, $id = NULL) {
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        if ($this->nameOfFunction == "admin")
            $pages = array('admin/header', 'crud/policajci', 'admin/footer');
        else
            $pages = array('container', 'crud/policajci', 'footer');

        $this->view->policajci = $prekrsaji->query("SELECT k.id_statusRacuna, k.oib, k.ime, k.prezime, k.email, k.korIme, k.adresa, k.id_tipKorisnika, p.naziv as uprava, d.naziv as slika, d.putanja FROM korisnici k LEFT JOIN datoteke d ON k.id_profilna_slika = d.id_datoteke LEFT JOIN policijske_uprave p ON k.id_policijske_uprave = p.id_policijske_uprave WHERE k.id_tipKorisnika = 2");
        $this->view->users = $prekrsaji->query("SELECT * FROM korisnici where id_tipKorisnika = 1 ");
        $this->view->uprave = $prekrsaji->query("SELECT * FROM policijske_uprave ");
        $this->view->advRender($pages);
    }

    

}
