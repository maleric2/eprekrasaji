<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of statistika
 *
 * @author Marko
 */
class Statistika extends Controller {
    function __construct() {
        parent::__construct();
        
    }
    
    function userStatistic($action = NULL, $id = NULL){
        require_once 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        $users=$prekrsaji->query("SELECT * FROM korisnici", array(null), true, false);
        if($action=="1"){ /* BROJ PRIJAVA U SUSTAVU */
            $this->view->brojPrijava= array();
            foreach ($users as $value) {
                $this->view->brojPrijava[$value['oib']]= new stdClass();
                $this->view->brojPrijava[$value['oib']]->ime=$value['ime'];
                $this->view->brojPrijava[$value['oib']]->prezime=$value['prezime'];
                $this->view->brojPrijava[$value['oib']]->oib=$value['oib'];
                $this->view->brojPrijava[$value['oib']]->korime=$value['korIme'];
                $brojPrijava=$prekrsaji->query("SELECT count(id_log) FROM log WHERE korisnici = ? and tip=1", array($value['oib']), true, false);
                $this->view->brojPrijava[$value['oib']]->prijava=$brojPrijava[0];
            }
            //var_dump($this->view->brojPrijava);
            $pages = array('admin/header', 'crud/statistika', 'admin/footer');
            
        }
        elseif($action=="2"){ /* BROJ PRIJAVA U SUSTAVU */
            $this->view->brojKoristenjaBaze= array();
            foreach ($users as $value) {
                $this->view->brojKoristenjaBaze[$value['oib']]= new stdClass();
                $this->view->brojKoristenjaBaze[$value['oib']]->ime=$value['ime'];
                $this->view->brojKoristenjaBaze[$value['oib']]->prezime=$value['prezime'];
                $this->view->brojKoristenjaBaze[$value['oib']]->oib=$value['oib'];
                $this->view->brojKoristenjaBaze[$value['oib']]->korime=$value['korIme'];
                $brojPrijava=$prekrsaji->query("SELECT count(id_log) FROM log WHERE korisnici = ? and tip=2", array($value['oib']), true, false);
                $this->view->brojKoristenjaBaze[$value['oib']]->prijava=$brojPrijava[0];
            }
            //var_dump($this->view->brojPrijava);
            $pages = array('admin/header', 'crud/statistika', 'admin/footer');
            
        }
       $this->view->advRender($pages); 
    }   
    
    
    
    
    
}
