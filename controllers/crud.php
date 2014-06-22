<?php

class crud extends Controller {

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

    function korisnici($action = NULL, $id = NULL) {
        require 'models/korisnici_model.php';
        $korisnici = new Korisnici_Model();
        $this->view->korisnici = $korisnici->getAllUsersInfo();

        if ($action == "update") {

            require 'controllers/korisnici.php';
            $korisnici_controller = new Korisnici();
            $user = $this->getObject($_POST);
            //var_dump($user);

            if ($korisnici_controller->validation($user, 2)) {
                require 'models/prekrsaji_model.php';
                $prekrsaji = new Prekrsaji_Model();

                $userOld = $korisnici->getUserInfo($user->korime);
                if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
                    if ($userOld["id_profilna_slika"]) {
                        $prekrsaji->deleteDatoteke($userOld["id_profilna_slika"]);
                    }
                    $datoteka = $this->insertSlikaInDir($_FILES, $user->korime);
                    $user->id_profilna_slika = $prekrsaji->insertDatoteke($datoteka);
                } else {
                    $user->id_profilna_slika  = $userOld["id_profilna_slika"];
                }
                //var_dump($user->id_profilna_slika);
                if ($korisnici->updateUser($user))
                    header('location:' . URL . 'admin/korisnici');
                else
                    header('location:' . URL . 'error');
            }
        }
        elseif ($action = "delete") {

            if ($id)
                if ($this->view->currentUser["id_tipKorisnika"] > 1) {
                    if ($korisnici->query("UPDATE korisnici SET id_statusRacuna = 1, obrisan = 1 where oib = ?", array($id)))
                        header('location:' . URL . 'korisnici');
                    else {
                        if ($this->view->currentUser["korIme"] === $id)
                            header('location:' . URL . 'login/logout');
                        else
                            header('location:' . URL . 'error/other/3');
                    }
                } else
                    header('location:' . URL . 'error/other/3');
            else
                header('location:' . URL . 'error/other/1');
        }

        //$this->view->render('korisnici/index');
        $pages = array('admin/header', 'crud/korisnici', 'admin/footer');
        $this->view->advRender($pages);
    }

    //action=null,change,delete,insert
    function prekrsaji($action = NULL, $id = NULL) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        /*      CHANGE      */
        if ($action == "change") {
            if (!$id)
                return false;
            $prekrsaj = $this->getObject($_POST);
            $prekrsaj->vrijeme_prekrsaja = $prekrsaj->datum . ' ' . $prekrsaj->vrijeme;
            $prekrsaj->id_prekrsaji = $id;
            //var_dump($prekrsaj);
            $korisnik = array();
            $brKorisnika = 0;
            foreach ($prekrsaj->oib as $korisnikPrekrsaja) {
                $korisnik[$brKorisnika] = new stdClass();
                $korisnik[$brKorisnika]->oib = $korisnikPrekrsaja;

                $dosje_id_dosje = $prekrsaji->query("SELECT ? from ? where oib = ?", array("dosje_id_dosje", "korisnici", $korisnik[$brKorisnika]->oib));
                //print_r($korisnik[$brKorisnika]);
                //print_r($dosje_id_dosje);
                if (empty($dosje_id_dosje[0])) {
                    $korisnik[$brKorisnika]->id_dosje = $prekrsaji->insertNewDosje($korisnik[$brKorisnika]);
                } else
                    $korisnik[$brKorisnika]->id_dosje = $dosje_id_dosje[0];
                //print_r($korisnik[$brKorisnika]->id_dosje);
                $brKorisnika++;
            }
            if (!$prekrsaji->update($prekrsaj))
                header('location:' . URL . 'error');
            /* PREKRSAJ ZA SVAKOG KORISNIKA */
            foreach ($korisnik as $korisnikPrekrsaja) {
                $korisnikPrekrsaja->id_prekrsaji = $prekrsaj->id_prekrsaji;
                $prekrsaji->insertPrekrsajKorisnika($korisnikPrekrsaja);
            }
            header('location:' . URL . 'admin/prekrsaji');
        } else if ($action == "delete") {
            if ($prekrsaji->delete($id))
                header('location:' . URL . 'admin/prekrsaji');
            else {
                header('location:' . URL . 'error');
            }

            /*      INSERT      */
        } else if ($action == "insert") {
            $prekrsaj = $this->getObject($_POST);
            $prekrsaj->vrijeme_prekrsaja = $prekrsaj->datum . ' ' . $prekrsaj->vrijeme;
            /* DOSJE */
            $korisnik = array();
            $brKorisnika = 0;
            foreach ($prekrsaj->oib as $korisnikPrekrsaja) {
                $korisnik[$brKorisnika] = new stdClass();
                $korisnik[$brKorisnika]->oib = $korisnikPrekrsaja;
                $dosje_id_dosje = $prekrsaji->query("SELECT ? from ? where oib = ?", array("dosje_id_dosje", "korisnici", $korisnik[$brKorisnika]->oib));
                //print_r($korisnik[$brKorisnika]);
                //print_r($dosje_id_dosje);
                if (empty($dosje_id_dosje[0])) {
                    $korisnik[$brKorisnika]->id_dosje = $prekrsaji->insertNewDosje($korisnik[$brKorisnika]);
                } else
                    $korisnik[$brKorisnika]->id_dosje = $dosje_id_dosje[0];
                //print_r($korisnik[$brKorisnika]->id_dosje);
                $brKorisnika++;
            }
            // A list of permitted file extensions
            $allowed = array('png', 'jpg', 'gif', 'zip');
            //echo '<pre>';
            //var_dump($_FILES['picture']);
            $file_ary = $this->reArrayFiles($_FILES['picture']);
            //var_dump($file_ary);
            $pic_number = 0;
            foreach ($file_ary as $file) {
                $datoteke[$pic_number] = new stdClass();
                $datoteke[$pic_number]->naziv = NULL;
                $datoteke[$pic_number]->putanja = NULL;
                if (isset($file) && $file['error'] == 0) {
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $datoteke[$pic_number]->naziv = $file['name']; /* */

                    if (!in_array(strtolower($extension), $allowed)) {
                        header('location:' . URL . 'error');
                    }

                    if (move_uploaded_file($file['tmp_name'], 'public/img/' . $file['name'])) {
                        $datoteke[$pic_number]->putanja = 'public/img/' . $file['name']; /* */
                    }
                    $pic_number++;
                }
            }
            $prekrsaj->id_prekrsaji = $prekrsaji->insert($prekrsaj);

            /* PREKRSAJ ZA SVAKOG KORISNIKA */
            foreach ($korisnik as $korisnikPrekrsaja) {
                $korisnikPrekrsaja->id_prekrsaji = $prekrsaj->id_prekrsaji;
                $prekrsaji->insertPrekrsajKorisnika($korisnikPrekrsaja);
            }

            if (!$prekrsaj->id_prekrsaji) {
                header('location:' . URL . 'error');
            } else {
                /* insert svih datoteka i slika */
                foreach ($datoteke as $picture) {
                    $prekrsaj->id_datoteke = $prekrsaji->insertDatoteke($picture);
                    $prekrsaji->insertPrilozi($prekrsaj);
                }

                header('location:' . URL . 'admin/prekrsaji');
            }

            //header('location:' . URL . 'admin/prekrsaji');
        } else if ($action == NULL)
            header('location:' . URL . 'admin/prekrsaji');
        else
            header('location:' . URL . 'error');

        $this->view->advRender($pages);
    }

    //action=null,change,delete,insert
    function slike($action = NULL, $id_prekrsaj = NULL, $id_slike = NULL) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($id_prekrsaj == 0)
            $id_prekrsaj = null;
        $prekrsaj->id_prekrsaji = $id_prekrsaj;

        if ($action == "insert") {
            $datoteke = $this->insertSlikeInDir($_FILES['picture']);
            if ($id_prekrsaj) {

                foreach ($datoteke as $picture) {
                    $prekrsaj->id_datoteke = $prekrsaji->insertDatoteke($picture);
                    $prekrsaji->insertPrilozi($prekrsaj);
                }
                header('location:' . URL . 'admin/slike/' . $prekrsaj->id_prekrsaji);
            }
            /* else insert datoteka za profilnu */
        } else if ($action == "delete") {
            if ($id_slike) {
                if ($prekrsaji->deleteDatoteke($id_slike))
                    header('location:' . URL . 'admin/slike/' . $prekrsaj->id_prekrsaji);
                else
                    header('location:' . URL . 'error');
            } else /* insert datoteka */
                header('location:' . URL . 'error');
        } else
            header('location:' . URL . 'error');
    }

    function insertSlikeInDir($files) {
        $allowed = array('png', 'jpg', 'gif', 'zip');
        $file_ary = $this->reArrayFiles($files);
        //var_dump($file_ary);
        $pic_number = 0;
        foreach ($file_ary as $file) {
            $datoteke[$pic_number] = new stdClass();
            $datoteke[$pic_number]->naziv = NULL;
            $datoteke[$pic_number]->putanja = NULL;
            if (isset($file) && $file['error'] == 0) {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $datoteke[$pic_number]->naziv = $file['name']; /* */

                if (!in_array(strtolower($extension), $allowed)) {
                    header('location:' . URL . 'error');
                }

                if (move_uploaded_file($file['tmp_name'], 'public/img/' . $file['name'])) {
                    $datoteke[$pic_number]->putanja = 'public/img/' . $file['name']; /* */
                }
                $pic_number++;
            }
        }
        return $datoteke;
    }

    /* INSERT POJEDINACNE SLIKE (PROFILE PICTURE) */

    function insertSlikaInDir($files, $path) {
        $allowed = array('png', 'jpg', 'gif', 'zip');
        $datoteka = new stdClass();
        $datoteka->naziv = NULL;
        $datoteka->putanja = NULL;
        if (isset($files['picture']) && $files['picture']['error'] == 0) {
            $extension = pathinfo($files['picture']['name'], PATHINFO_EXTENSION);
            $datoteka->naziv = $files['picture']['name'];

            if (!in_array(strtolower($extension), $allowed)) {
                header('location:' . URL . 'error');
            }
            if (!file_exists('public/img/' . $path)) {
                mkdir('public/img/' . $path, 0777, true);
            }
            if (move_uploaded_file($files['picture']['tmp_name'], 'public/img/' . $path . '/' . $files['picture']['name'])) {
                $datoteka->putanja = 'public/img/' . $path . '/' . $files['picture']['name'];
            }
        }
        return $datoteka;
    }

    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    /* RETURNS JSON */
    /* preko ajax-a bez headera */

    function uprave($action = null, $id = null) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "insert") {
            $uprave = $this->getObject($_POST);
            //var_dump($uprave);
            $upit = $prekrsaji->query("INSERT INTO policijske_uprave SET naziv = ?, zupanije_id_zupanije = ? ", array($uprave->uprava, $uprave->zupanija));
            $zupanije = $prekrsaji->query("SELECT * FROM zupanije where id_zupanije = ?", array($uprave->zupanija));
            if ($upit)
                print json_encode(array("uprava" => $uprave->uprava, "zupanija" => $zupanije['naziv'], "id_policijske_uprave" => $upit));
        }
        elseif ($action == "delete") {
            if ($id) {
                $upit = $prekrsaji->query("DELETE FROM policijske_uprave WHERE id_policijske_uprave = ? ", array($id));
                if ($upit)
                    echo 1;
            }
        }
        elseif ($action == "update") {
            if ($id) {
                $uprave = $this->getObject($_POST);
                $upit = $prekrsaji->query("UPDATE policijske_uprave SET naziv = ?, zupanije_id_zupanije = ?  WHERE id_policijske_uprave = ?", array($uprave->uprava, $uprave->zupanija, $id));
                $zupanije = $prekrsaji->query("SELECT * FROM zupanije where id_zupanije = ?", array($uprave->zupanija));
                if ($upit)
                    print json_encode(array("uprava" => $uprave->uprava, "zupanija" => $zupanije['naziv'], "id_policijske_uprave" => $id));
            }
        }
    }

    function zupanije($action = null, $id = null) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "insert") {
            $zupanije = $this->getObject($_POST);
            //var_dump($uprave);
            $upit = $prekrsaji->query("INSERT INTO zupanije SET naziv = ?", array($zupanije->naziv));
            if ($upit)
                print json_encode(array("naziv" => $zupanije->naziv, "id_zupanije" => $upit));
        }
        elseif ($action == "delete") {
            if ($id) {
                $upit = $prekrsaji->query("DELETE FROM zupanije WHERE id_zupanije = ? ", array($id));
                if ($upit)
                    echo 1;
            }
        }
        elseif ($action == "update") {
            if ($id) {
                $zupanije = $this->getObject($_POST);
                $upit = $prekrsaji->query("UPDATE zupanije SET naziv = ?  WHERE id_zupanije = ?", array($zupanije->naziv, $id));
                if ($upit)
                    print json_encode(array("naziv" => $zupanije->naziv, "id_zupanije" => $upit));
            }
        }
    }

    function zalbe($action = null, $id = null) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "insert") {
            $zalba = $this->getObject($_POST);
            //var_dump($uprave);
            $upit = $prekrsaji->query("INSERT INTO zalbe SET naziv = ?, opis = ?, id_prekrsaji = ?", array($zalba->naziv, $zalba->opis, $zalba->id_prekrsaji));
            if ($upit)
                header('location:' . URL . 'korisnici/zalbe');
            else
                header('location:' . URL . 'error');
        }
        elseif ($action == "delete") {
            $upit = $prekrsaji->query("DELETE FROM zalbe where id_zalbe = ?", array($id));
            if ($upit)
                header('location:' . URL . 'korisnici/zalbe');
            else
                header('location:' . URL . 'error');
        }
        elseif ($action == "update") {
            $zalba = $this->getObject($_POST);
            $upit = $prekrsaji->query("UPDATE zalbe SET naziv = ?, opis = ?, id_prekrsaji = ? WHERE id_zalbe = ? ", array($zalba->naziv, $zalba->opis, $zalba->id_prekrsaji, $id));
            if ($upit)
                header('location:' . URL . 'korisnici/zalbe');
            else
                header('location:' . URL . 'error');
        }
    }

    function policajci($action = null, $id = null) {
        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();
        if ($action == "policajac") {
            $policajac = $this->getObject($_POST);
            //var_dump($uprave);
            $upit = $prekrsaji->query("UPDATE korisnici SET id_tipKorisnika = 2 WHERE oib = ?", array($policajac->oib));
            if ($upit)
                header('location:' . URL . 'admin/policajci');
            else
                header('location:' . URL . 'error');
        }
    }

}
