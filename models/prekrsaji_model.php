<?php

class Prekrsaji_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    public function getAllPrekrsaji() {
        $sth= $this->db->prepare("SELECT * FROM prekrsaji");
        $sth->execute();
        $data=$sth->fetchAll();
        return $data;
    }
    /* Sredit unos, oib ispisat ime prezime a oib je value*/
    /* POLICAJAC OIB POLICAJAC, veze se preko*/
    public function insert($item) {
        if(empty($item->adresa)) $item->adresa=NULL;

        $sth= $this->db->prepare("INSERT INTO prekrsaji VALUES "
                . "(:id, :vrijeme, :id_kategorija, :mjesto, :opis,"
                . " :vrijeme_zastare, :oib_policajca )");
        $send=$sth->execute(array(
                ':id' => "DEFAULT",
                ':vrijeme' => $item->vrijeme_prekrsaja,
                ':id_kategorija' => $item->id_kategorije_prekrsaja,
                ':mjesto' => $item->mjesto,
                ':opis' => $item->opis,
                ':vrijeme_zastare' => $item->vrijeme_zastare,
                ':oib_policajca' => $item->policajac_oib_policajac
                ));


        //print_r($sth->errorInfo());
        /* napravit funkciju koja senda u logove unutar Model*/
        if ($send) {
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));

            $last_id =  $this->db->lastInsertId();
            return $last_id;
        } else {
            return false;
        }
    }
    public function delete($id) {
        $sth= $this->db->prepare("DELETE FROM prekrsaji WHERE id_prekrsaji=:id");
        $send=$sth->execute(array(
                ':id' => $id,
                ));
        /* napravit funkciju koja senda u logove unutar Model*/
        if ($send) {
            /*$sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "delete",
                ':oib' => null
            ));*/
            return true;
        } else {
            return false;
        }
    }
    public function getAllKategorije() {
        $sth= $this->db->prepare("SELECT * FROM kategorije_prekrsaja");
        $sth->execute();
        $data=$sth->fetchAll();
        return $data;
    }
    public function getAllActiveKategorije() {
        $sth= $this->db->prepare("SELECT * FROM kategorije_prekrsaja WHERE aktivno='1'");
        $sth->execute();
        $data=$sth->fetchAll();
        return $data;
    }
    public function getAllDatoteke($id_prekrsaj) {
        $sth= $this->db->prepare("SELECT * FROM prilozi p JOIN datoteke d ON p.datoteke_id_datoteke = d.id_datoteke WHERE prekrsaji_id_prekrsaji=:id_prekrsaj");
        $sth->execute(array(
                ':id_prekrsaj' => $id_prekrsaj
                ));
        $data=$sth->fetchAll();
        return $data;
    }
    public function insertPrilozi($item){
        if(!$item->id_prekrsaji)return false;      
        if(!$item->id_datoteke) return false;
        
        
        $sth= $this->db->prepare("INSERT INTO prilozi VALUES "
                . "(:id_prilozi, :prekrsaji_id_prekrsaji, :datoteke_id_datoteke )");
        $send=$sth->execute(array(
                ':id_prilozi' => "DEFAULT",
                ':prekrsaji_id_prekrsaji' => $item->id_prekrsaji,
                ':datoteke_id_datoteke' => $item->id_datoteke
                ));
        /* napravit funkciju koja senda u logove unutar Model*/
        if ($send) {
            /*$sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));*/
            return true;
        } else {
            return false;
        }
    }
    
    
}
