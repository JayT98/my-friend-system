<?php
include_once "session.php";

$db = new Database();
$auth = new Authentication($db);
$auth->logout();

if (!$auth->isAuthenticated()) {
    destroySession();
    header("Location: index.php");
} else {
    echo "Logging out Error";
}
