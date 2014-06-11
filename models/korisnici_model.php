<?php

class Korisnici_Model extends Model {

    function __construct() {
        parent::__construct();
        $this->putanja.="->Korisnici_Model";
    }
    
    public function getAllUsersInfo() {
        $sth= $this->db->prepare("SELECT * FROM korisnici k LEFT JOIN datoteke d ON k.id_profilna_slika=d.id_datoteke");
        $sth->execute();
        $data=$sth->fetchAll();
        //ako nema sliku
        for($i=0;$i<count($data);$i++){
            if(!$data[$i]['id_profilna_slika']) $data[$i]['putanja']="user1.png";
        }
        return $data;
    }
    public function getAllModUsers() {
        $sth= $this->db->prepare("SELECT * FROM korisnici WHERE id_tipKorisnika=2");
        $sth->execute();
        $data=$sth->fetchAll();
        return $data;
    }
    public function getUserInfo($korIme) {
               
        $sth= $this->db->prepare("SELECT * FROM korisnici k LEFT JOIN datoteke d ON k.id_profilna_slika=d.id_datoteke WHERE "
                . "korIme = :korime");
        $sth->execute(array(':korime' => $korIme ));
        $data=$sth->fetch();
        //ako nema sliku
        if(!$data['id_profilna_slika']) $data['putanja']="user1.png";
        return $data;

    }
    /*public function updateUser($item) {
          
        $sth= $this->db->prepare("UPDATE korisnici SET "
                . " id_statusRacuna=:status,"
                . " obrisan=:obrisan"
                . " WHERE oib=:oib");
        $send=$sth->execute(array(
                ':oib' => $item->oib,
                ':status' => $item->status,
                ':obrisan' => $item->obrisan
                ));
        //Session::update("user", null, null, null, null, $item->status);
        if ($send){
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => 'default',
                ':time' => 'now()',
                ':radnja' => "aktivacija",
                ':oib' => $item->oib
            ));           
            header('location:' . URL . 'korisnici');
        } else {
            header('location:' . URL . 'error/1');
        }
      }*/
      public function updateUser($item) {
               
        $sth= $this->db->prepare("UPDATE korisnici SET "
                . " ime=:ime, prezime=:prezime, email=:email,"
                . " lozinka=:pass,"
                . " adresa=:adresa WHERE korIme=:username");
        $send=$sth->execute(array(
                ':ime' => $item->ime,
                ':prezime' => $item->prezime,
                ':email' => $item->email,
                ':username' => $item->korime,
                ':pass' => $item->pass,
                ':adresa' => $item->adresa
                ));
        
        if ($send) {
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "azuriranje",
                ':oib' => $item->oib
            ));
        
            /*header('location:' . URL . 'korisnici');*/
            return true;
        } else {
           /* header('location:' . URL . 'error/1');*/
            return false;
        }
    }
    public function insertUser($item) {
        if(empty($item->adresa)) $item->adresa=NULL;
        if(empty($item->ime)) $item->ime=NULL;
        if(empty($item->prezime)) $item->prezime=NULL;
        //var_dump($item);
        $sth= $this->db->prepare("INSERT INTO korisnici VALUES "
                . "(:oib, :ime, :prezime, :email, :username,"
                . " :pass, :tipKor, :obrisan, :statusRac, :dosje, :zupanija,"
                . " :avatar, :adresa)");
        $send=$sth->execute(array(
                ':oib' => $item->oib,
                ':ime' => $item->ime,
                ':prezime' => $item->prezime,
                ':email' => $item->email,
                ':username' => $item->korime,
                ':pass' => $item->pass,
                ':tipKor' => 1,
                ':obrisan' => 0,
                ':statusRac' => 1,
                ':dosje' => NULL,
                ':zupanija' => NULL,
                ':avatar' => NULL,
                ':adresa' => $item->adresa
                ));
        
        if ($send) {
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));
            return true;
        } else {
            return false;
        }
    }
}
