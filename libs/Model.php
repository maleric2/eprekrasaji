<?php

class Model {

    function __construct() {
        $this->db = new Database();
        $this->putanja.="->Model";
    }
    /* returns dataID */
    public function insertDatoteke($item){
        
        $sth= $this->db->prepare("INSERT INTO datoteke VALUES "
                . "(:id_datoteke, :naziv, :putanja )");
        $send=$sth->execute(array(
                ':id_datoteke' => "DEFAULT",
                ':naziv' => $item->naziv,
                ':putanja' => $item->putanja
                ));

        if ($send) {
            /*$sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));*/
            $last_id =  $this->db->lastInsertId();
            return $last_id;
        } else {
            return false;
        }
    }

}
