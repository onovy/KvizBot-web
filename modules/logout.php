<?php
    setcookie("logout", 1, ["path" => "/", "secure" => true, "httponly" => true, "samesite" => "Strict"]);
    include 'uvod.php';
