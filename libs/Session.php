<?php

class Session {

    public static function init(){
        @session_start();
    }
    public static function set($key, $value){
        $_SESSION[$key]=$value;
    }
    
    public static function get($key){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
    }
    public static function destroy(){
        session_destroy();
    }
    public static function update($key, $oib=null, $ime=null, $prezime=null, $email=null, $id_statusRacuna=null){
        @session_start();
        $Session_value=self::get($key);
        if($Session_value){
            if(!empty($oib))$Session_value['oib']=$oib;
            if(!empty($ime))$Session_value['ime']=$ime;
            if(!empty($prezime))$Session_value['prezime']=$prezime;
            if(!empty($email))$Session_value['email']=$email;
            if(!empty($id_statusRacuna))$Session_value['id_statusRacuna']=$id_statusRacuna;
            self::set($key, $Session_value);
        }
    }
    
}

