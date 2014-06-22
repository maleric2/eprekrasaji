<?php

class Error extends Controller{

    function __construct() {
        parent::__construct();
    }
    
    function index() {
	$this->view->msg = 'This page doesnt exist';
	$this->view->render('error/index');
    }
    function register($id) {
	$this->view->msg = 'Problem kod korisnickih podataka';
        if ($id == 1) {
            $this->view->details = 'Lozinke nisu jednake';
            $this->view->more = 'Vratite se natrag i provjerite ispravnost lozinki';
        }
        elseif ($id == 2) {
            $this->view->details = 'Nisu uneseni svi podaci';
            $this->view->more = 'Vratite se natrag i unesite sve podatke';
        }
        elseif ($id == 3) {
            $this->view->details = 'Neispravan email';
            $this->view->more = 'Vratite se natrag i unesite ispravan email';
        }
        elseif ($id == 4) {
            $this->view->details = 'Ime uneseno neispravno';
            $this->view->more = 'Vratite se natrag i unesite Ime velikim početnim slovom bez brojeva';
        }
        elseif ($id == 5) {
            $this->view->details = 'Prezime uneseno neispravno';
            $this->view->more = 'Vratite se natrag i unesite Prezime velikim početnim slovom bez brojeva';
        }
        elseif ($id == 6) {
            $this->view->details = 'Neispravno unesena capatcha';
            $this->view->more = 'Vratite se natrag i ispravno unesite slova i brojeve sa slike';
        }
        
        $this->view->render('error/index');
    }
    function other($id) {
        $this->view->msg = 'Dogodila se greska';
        if ($id == 1) {
            $this->view->details = 'Nazalost dogodila se greska prilikom slanja mail-a';
        }
        
        elseif ($id == 2) {
            $this->view->details = 'Nije moguce pregledavati detalje ostalih korisnika';
            $this->view->more = "<a href='". URL . "korisnici'>Vratite se natrag</a>";
        }
        elseif ($id == 3) {
            $this->view->details = 'Nemate ovlasti za izvrsavanje trazene funkcije';
        }
        
        
        elseif ($id == 7) {
            $this->view->details = 'Neispravan korisnik ili korisničko ime';
            $this->view->more = 'Nepostojeći podatak ili korisnik sa neispravnim korisničkim imenom';
        }
        $this->view->render('error/index');
    }
    function login($id) {
        $this->view->msg = 'Dogodila se greska pri prijavi';
        if ($id == 1) {
            $this->view->details = 'Vas racun je obrisan';
        }    
        $this->view->render('error/index');
    }
}
