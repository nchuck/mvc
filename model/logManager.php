<?php

require_once 'dbconn.php';

class LogManager {

    function login($mail, $pass){
        $conn = new DatabaseConnection();
        $mail = "'".$mail."'";
        $pass = ",'".$pass."'";
        $ans = $conn->singleton('SELECT check_login('.$mail.$pass.')');
        if($ans){
            $userdata = $conn->raw('CALL nombreLector('.$mail.')')->fetch();
            $_SESSION['username'] = $userdata['nombre_lector'];
            $_SESSION['city'] = $userdata['ciudad_lector'];
            $_SESSION['id'] = $userdata['id_lector'];
            $_SESSION['user_type'] = $userdata['id_tipo_usuario'];
            session_regenerate_id();
        }
        return $ans;
    }

    function logout(){
        $conn = new DatabaseConnection();
        $conn->singleton('SELECT logout('.$conn->quote($_SESSION['mail']).')');
    }

}