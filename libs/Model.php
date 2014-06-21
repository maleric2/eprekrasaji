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
    public function query($queryString, $param = NULL, $formatValue = true) {
        if ($param != NULL) {
            foreach ($param as $value) {
                $limit = 1;
                $queryString = preg_replace("/\?/", "'".$value."'", $queryString, $limit);
            }
        }
        //echo $queryString;

        $sth = $this->db->prepare($queryString);
        $send = $sth->execute();
        //print_r($sth->errorInfo());
        //print_r (strpos($queryString, "SELECT"));

        if (strpos($queryString, "SELECT") !== false) {
            $data = $sth->fetchAll();
            if (count($data) > 1)
                return $data;
            elseif (count($data) == 1 && $formatValue) {
                return $data[0];
            } else
                return false;
        }
        elseif (strpos($queryString, "INSERT") !== false) {
            if ($send)
                return $this->db->lastInsertId();
            else
                return false;
        }
        elseif (strpos($queryString, "UPDATE") !== false) {
            if ($send)
                return true;
            else
                return false;
        }
        elseif (strpos($queryString, "DELETE") !== false) {
            if ($send)
                return true;
            else
                return false;
        } else
            return false;
    }

}
