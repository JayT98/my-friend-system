<?php
    if(!isset($_SESSION)){
        session_start();
    }

    include_once "database.php";
    include_once "authentication.php";
    include_once "account.php";
    include_once "friends.php";

    function destroySession(){
        if(!isset($_SESSION)){
            session_unset();
            session_destroy();
        }
    }
?>