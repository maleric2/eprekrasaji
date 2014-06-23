<?php

class Model {

    function __construct() {
        $this->db = new Database();
        $this->putanja.="->Model";
    }

    /* returns dataID */

    public function insertDatoteke($item) {

        $sth = $this->db->prepare("INSERT INTO datoteke VALUES "
                . "(:id_datoteke, :naziv, :putanja )");
        $send = $sth->execute(array(
            ':id_datoteke' => "DEFAULT",
            ':naziv' => $item->naziv,
            ':putanja' => $item->putanja
        ));

        if ($send) {
            /* $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
              . "(:id, :time, :radnja, :oib)");
              $send = $sth->execute(array(
              ':id' => "default",
              ':time' => "now()",
              ':radnja' => "registracija",
              ':oib' => $item->oib
              )); */
            $last_id = $this->db->lastInsertId();
            return $last_id;
        } else {
            return false;
        }
    }

    public function query($queryString, $param = NULL, $formatValue = true, $statistic=true) {
        if ($param != NULL) {
            foreach ($param as $value) {
                $limit = 1;
                $queryString = preg_replace("/\?/", "'" . $value . "'", $queryString, $limit);
            }
        }
        //echo $queryString;

        $sth = $this->db->prepare($queryString);
        $send = $sth->execute();
        //print_r($sth->errorInfo());
        //print_r (strpos($queryString, "SELECT"));
        if($send && $statistic)
            $this->insertInLog(array("tip"=>2, "upit"=>$queryString));
        
        if (strpos($queryString, "SELECT") !== false) {
            $data = $sth->fetchAll();
            if (count($data) > 1)
                return $data;
            elseif (count($data) == 1 && $formatValue)
                return $data[0];
            else if(count($data) == 1) return $data;
            else
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

    public function insertInLog($param) {
        $param['vrijeme'] = $this->vrijeme();
        if ($param['tip'] == 1) { /* PRIJAVA */
            $param['upit'] = NULL; 
        } elseif ($param['tip'] == 2) { /* BAZA */
            $param['radnja'] = NULL;
        } else { /* Ostale radnje */
            $param['upit'] = NULL;
        }
        if(!$param['korisnik']){
            Session::init();
            $korisnik = Session::get('user'); 
            $param['korisnik']=$korisnik['oib'];
        }
        //var_dump($param);
        $sth = $this->db->prepare("INSERT INTO log VALUES "
                . "(:id, :tip, :vrijeme , :radnja, :upit, :korisnik)");
        $send = $sth->execute(array(
            ':id' => "DEFAULT",
            ':tip' => $param['tip'],
            ':vrijeme' => $param['vrijeme'],
            ':radnja' => $param['radnja'],
            ':upit' => $param['upit'],
            ':korisnik' => $param['korisnik']
        ));
        //print_r($sth->errorInfo());
        if ($send)
            return true;
        else
            return false;
    }

    public function vrijeme() {
        $date = date('Y-m-d H:i:s');
        return $date;
    }

    public function insertInSession($param) {
        if ($param['vrijeme'])
            $param['vrijeme_pocetak'] = $param['vrijeme'];
        if ($param['id_sesija']) {
            $param['vrijeme_zavrsetak'] = $this->vrijeme();
            $upit = $this->query("UPDATE sesija SET vrijeme_zavrsetka = ? WHERE id_sesija = ?", array($param['vrijeme_zavrsetak'], $param['id_sesija']));
            return $upit;
        } else {
            $param['vrijeme_zavrsetak'] = NULL;
            if (!$param['vrijeme_pocetak'])
                $param['vrijeme_pocetak'] = $this->vrijeme();

            $sth = $this->db->prepare("INSERT INTO sesija VALUES "
                    . "(:id, :korisnik, :vrijeme_pocetak , :vrijeme_zavrsetak)");
            $send = $sth->execute(array(
                ':id' => "DEFAULT",
                ':korisnik' => $param['korisnik'],
                ':vrijeme_pocetak' => $param['vrijeme_pocetak'],
                ':vrijeme_zavrsetak' => $param['vrijeme_zavrsetak'],
            ));
            if ($send)
                return $this->db->lastInsertId();
            else
                return false;
        }
    }

}
