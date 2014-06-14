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

    function korisnici() {
        require 'models/korisnici_model.php';
        $korisnici = new Korisnici_Model();
        $this->view->korisnici = $korisnici->getAllUsersInfo();
        //$this->view->render('korisnici/index');
        $pages = array('admin/header', 'korisnici/index', 'admin/footer');
        $this->view->advRender($pages);
    }

    //action=null,change,delete,insert
    function prekrsaji($action = NULL, $id = NULL) {

        require 'models/prekrsaji_model.php';
        $prekrsaji = new Prekrsaji_Model();

        /*      CHANGE      */  
        if ($action == "change") {
            $prekrsaj = $this->getObject($_POST);
            $prekrsaji->update($prekrsaj);
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

            if (!$prekrsaj->id_prekrsaji) {
                header('location:' . URL . 'error');
            } else {
                /* insert svih datoteka i slika*/
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

}
