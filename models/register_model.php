<?php

class Register_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    public function run($item) {
               
        $sth= $this->db->prepare("INSERT INTO korisnici VALUES "
                . "(:oib, :ime, :prezime, :email, :username,"
                . " :pass, :tipKor, :aktiviran, :statusRac, :dosje, :zupanija,"
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
            
            $poruka = "Postovani, "
                    . " za dovrsetak registracije kliknite na sljedeci link: "
                    . "http://arka.foi.hr/WebDiP/2013/zadaca_05/maleric/register/activate/{$item->korime}";
            $this->sendMail($item->email,"Potvrdite registraciju",$poruka, "maleric@foi.hr");
            
            header('location:' . URL . 'register/success');
        } else {
            header('location:' . URL . 'register');
        }
    }
    public function check($item) {
               
        $sth= $this->db->prepare("SELECT :item FROM korisnici WHERE :item=:value");
        $send=$sth->execute(array(
                ':item' => $item->item,
                ':value' => $item->value,
                ));
        
        if ($send) {
           return true;
        } else {
           return false;
        }
    }
    
    public function update($item) {
               
        $sth= $this->db->prepare("UPDATE korisnici SET "
                . " oib=:oib, ime=:ime, prezime=:prezime, email=:email,"
                . " lozinka=:pass,"
                . " adresa=:adresa WHERE korIme=:username");
        $send=$sth->execute(array(
                ':oib' => $item->oib,
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
            
            $poruka = "Postovani, ". $item->ime ." ". $item->prezime
                    . " uspjesno ste azurirali podatke. ";
            $this->sendMail($item->email,"Uspjesno azuriranje",$poruka, "maleric@foi.hr");
            //azuriraj i session
            /*Session::init();
            $user=Session::get('user');
            $user['oib']=$item->oib;
            $user['ime']=$item->ime;
            $user['prezime']=$item->prezime;
            $user['email']=$item->email;
            Session::set('user', $user);*/
            Session::update("user", null, null, null, null, $item->status);
            
            header('location:' . URL . 'korisnici');
        } else {
            header('location:' . URL . 'korisnici/change/'.$item->korime);
        }
    }
    public function sendMail($to, $subject,$message,$from){
        
            if (mail($to, $subject, $message, "From: ".$from)) {
                header("Location: korisnici.php");
            } else
                header('location:' . URL . 'error/other/1');
    }
}
