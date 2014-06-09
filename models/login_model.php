<?php

class Login_Model extends Model {

    function __construct() {
        parent::__construct();

        
    }
    public function run() {
               
        $sth= $this->db->prepare("SELECT oib, korIme,ime, prezime, email, id_tipKorisnika, id_statusRacuna, obrisan  FROM korisnici WHERE "
                . "korIme = :korIme AND lozinka = :lozinka");
        $sth->execute(array(
                ':korIme' => $_POST['korime'],
                ':lozinka' => $_POST['lozinka']
                ));
        $data=$sth->fetchAll();
        $count = $sth->rowCount();
        //sesija
        if($count>0){
            if($data[0]['obrisan']) header('location:' . URL .'error/login/1');
            else {
                Session::init();
                Session::set('user', $data[0]);
                Session::set('loggedIn', true);
                setcookie("user", $data[0]['korIme'], time()+3600,"/");
                header('location:' . URL .'korisnici');
            }
        }else{
            //show error
            header('location:' . URL .'login');
        }
    }
    

}

