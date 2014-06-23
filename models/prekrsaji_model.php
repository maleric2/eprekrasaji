<?php

class Prekrsaji_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getAllPrekrsaji() {
        $sth = $this->db->prepare("SELECT * FROM prekrsaji");
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    /* insert new dosje: update korisnici->dosje, if dosje=NULL,
     *                  new dosje
     *                  prekrsaj_korisnika(id_prekrsaja NOVOG, id_dosje POSTOJECI)
     */

    public function getUserPrekrsaji($username) {
        $sth = $this->db->prepare("SELECT * FROM korisnici k "
                . "JOIN dosje d ON k.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaj_korisnika p ON p.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaji pr ON pr.id_prekrsaji=p.prekrsaji_id_prekrsaji WHERE korIme=:username");
        $sth->execute(array(
            ':username' => $username
        ));
        $data = $sth->fetchAll();
        return $data;
    }

    public function getUsersZalbe($oib) {
        $sth = $this->db->prepare("SELECT z.id_zalbe, z.status as status, z.naziv as naziv, z.opis as opis, z.id_prekrsaji as id_prekrsaji FROM korisnici k "
                . "JOIN dosje d ON k.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaj_korisnika p ON p.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaji pr ON pr.id_prekrsaji=p.prekrsaji_id_prekrsaji "
                . "JOIN zalbe z ON pr.id_prekrsaji=z.id_prekrsaji where k.oib=:oib");
        $sth->execute(array(
            ':oib' => $oib
        ));
        $data = $sth->fetchAll();
        return $data;
    }

    public function getPrekrsajiUsers($prekrsaj) {
        $sth = $this->db->prepare("SELECT * FROM korisnici k "
                . "JOIN dosje d ON k.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaj_korisnika p ON p.dosje_id_dosje=d.id_dosje "
                . "JOIN prekrsaji pr ON pr.id_prekrsaji=p.prekrsaji_id_prekrsaji WHERE pr.id_prekrsaji=:prekrsaj");
        $sth->execute(array(
            ':prekrsaj' => $prekrsaj
        ));
        $data = $sth->fetchAll();
        return $data;
    }

    /* Sredit unos, oib ispisat ime prezime a oib je value */
    /* POLICAJAC OIB POLICAJAC, veze se preko */

    public function insert($item) {
        if (empty($item->adresa))
            $item->adresa = NULL;

        $sth = $this->db->prepare("INSERT INTO prekrsaji VALUES "
                . "(:id, :vrijeme, :id_kategorija, :mjesto, :opis,"
                . " :vrijeme_zastare, :oib_policajca )");
        $send = $sth->execute(array(
            ':id' => "DEFAULT",
            ':vrijeme' => $item->vrijeme_prekrsaja,
            ':id_kategorija' => $item->id_kategorije_prekrsaja,
            ':mjesto' => $item->mjesto,
            ':opis' => $item->opis,
            ':vrijeme_zastare' => $item->vrijeme_zastare,
            ':oib_policajca' => $item->policajac_oib_policajac
        ));
        //print_r($sth->errorInfo());
        /* napravit funkciju koja senda u logove unutar Model */
        if ($send) {
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));

            $last_id = $this->db->lastInsertId();
            return $last_id;
        } else {
            return false;
        }
    }

    public function update($item) {
        $sth = $this->db->prepare("UPDATE prekrsaji SET"
                . " vrijeme_prekrsaja=:vrijeme, id_kategorije_prekrsaja=:id_kategorija, mjesto=:mjesto, opis=:opis,"
                . " vrijeme_zastare=:vrijeme_zastare, policajac_oib_policajac=:oib_policajca"
                . " WHERE id_prekrsaji=:id");
        $send = $sth->execute(array(
            ':id' => $item->id_prekrsaji,
            ':vrijeme' => $item->vrijeme_prekrsaja,
            ':id_kategorija' => $item->id_kategorije_prekrsaja,
            ':mjesto' => $item->mjesto,
            ':opis' => $item->opis,
            ':vrijeme_zastare' => $item->vrijeme_zastare,
            ':oib_policajca' => $item->policajac_oib_policajac
        ));
        //print_r($sth->errorInfo());
        /* napravit funkciju koja senda u logove unutar Model */
        if ($send) {
            $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
                    . "(:id, :time, :radnja, :oib)");
            $send = $sth->execute(array(
                ':id' => "default",
                ':time' => "now()",
                ':radnja' => "registracija",
                ':oib' => $item->oib
            ));

            $last_id = $this->db->lastInsertId();
            return $last_id;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $sth = $this->db->prepare("DELETE FROM prekrsaji WHERE id_prekrsaji=:id");
        $send = $sth->execute(array(
            ':id' => $id,
        ));
        /* napravit funkciju koja senda u logove unutar Model */
        if ($send) {
            /* $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
              . "(:id, :time, :radnja, :oib)");
              $send = $sth->execute(array(
              ':id' => "default",
              ':time' => "now()",
              ':radnja' => "delete",
              ':oib' => null
              )); */
            return true;
        } else {
            return false;
        }
    }

    public function getAllKategorije() {
        $sth = $this->db->prepare("SELECT * FROM kategorije_prekrsaja");
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function getAllActiveKategorije() {
        $sth = $this->db->prepare("SELECT * FROM kategorije_prekrsaja WHERE aktivno='1'");
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function getDatoteke($id_prekrsaj) {
        $sth = $this->db->prepare("SELECT * FROM prilozi p JOIN datoteke d ON p.datoteke_id_datoteke = d.id_datoteke WHERE prekrsaji_id_prekrsaji=:id_prekrsaj");
        $sth->execute(array(
            ':id_prekrsaj' => $id_prekrsaj
        ));
        $data = $sth->fetchAll();
        return $data;
    }

    public function getAllDatoteke() {
        $sth = $this->db->prepare("SELECT * FROM datoteke");
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function deleteDatoteke($id_datoteke) {
        $sth = $this->db->prepare("DELETE FROM datoteke WHERE id_datoteke=:id");
        $send = $sth->execute(array(
            ':id' => $id_datoteke
        ));
        if ($send)
            return true;
        else
            return false;
    }

    public function insertPrilozi($item) {
        if (!$item->id_prekrsaji)
            return false;
        if (!$item->id_datoteke)
            return false;


        $sth = $this->db->prepare("INSERT INTO prilozi VALUES "
                . "(:id_prilozi, :prekrsaji_id_prekrsaji, :datoteke_id_datoteke )");
        $send = $sth->execute(array(
            ':id_prilozi' => "DEFAULT",
            ':prekrsaji_id_prekrsaji' => $item->id_prekrsaji,
            ':datoteke_id_datoteke' => $item->id_datoteke
        ));
        /* napravit funkciju koja senda u logove unutar Model */
        if ($send) {
            /* $sth = $this->db->prepare("INSERT INTO tipOstaleRadnje VALUES "
              . "(:id, :time, :radnja, :oib)");
              $send = $sth->execute(array(
              ':id' => "default",
              ':time' => "now()",
              ':radnja' => "registracija",
              ':oib' => $item->oib
              )); */
            return true;
        } else {
            return false;
        }
    }

    public function insertPrekrsajKorisnika($item) {
        if (!$item->prekrsaji_id_prekrsaji) {
            if (!$item->id_prekrsaji)
                return false;
            $item->prekrsaji_id_prekrsaji = $item->id_prekrsaji;
        }
        if (!$item->dosje_id_dosje) {
            if (!$item->id_dosje)
                return false;
            $item->dosje_id_dosje = $item->id_dosje;
        }


        $sth = $this->db->prepare("INSERT INTO prekrsaj_korisnika VALUES "
                . "(:prekrsaj, :dosje )");
        $send = $sth->execute(array(
            ':prekrsaj' => $item->prekrsaji_id_prekrsaji,
            ':dosje' => $item->dosje_id_dosje
        ));
        /* napravit funkciju koja senda u logove unutar Model */
        //print_r($sth->errorInfo());
        if ($send) {
            return true;
        } else {
            return false;
        }
    }

    public function insertNewDosje($item) {
        if (!$item->oib)
            return false;

        $sth = $this->db->prepare("INSERT INTO dosje VALUES "
                . "(:dosje, now() )");
        $send = $sth->execute(array(
            ':dosje' => "DEFAULT"
        ));
        $item->id_dosje = $this->db->lastInsertId();
        /* print_r($item->oib);
          echo "   ";
          print_r($item->id_dosje);
          echo "<br>"; */
        /* napravit funkciju koja senda u logove unutar Model */
        if ($send) {
            $sth = $this->db->prepare("UPDATE korisnici SET "
                    . "dosje_id_dosje=:dosje WHERE oib=:oib");
            $send = $sth->execute(array(
                ':dosje' => $item->id_dosje,
                ':oib' => $item->oib
            ));
            /* print_r($item->oib);
              echo "   ";
              print_r($item->id_dosje);
              echo "<br>";
              print_r($sth->errorInfo()); */
            return $item->id_dosje;
        } else {
            return false;
        }
    }

}
