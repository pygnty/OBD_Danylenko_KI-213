<?php
    if(!isset($_COOKIE["rights"])) 
        header('Location: http://localhost/noPrivelegies.php');

function gerarahere($minimalRights)
{
    global $connection;
    $rights = pg_fetch_all(pg_execute($connection, "get_rights", array($_COOKIE["login"])))[0]["rights"];
    if (!(($rights & $minimalRights) == $minimalRights)) {
        header('Location: http://localhost/noPriveleges.php');
    }
}

function checkRights($newRights)
{
    global $connection;
    $rights = pg_fetch_all(pg_execute($connection, "get_rights", array($_COOKIE["login"])))[0]["rights"];
    if ($rights < intval($newRights)) {
        header('Location: http://localhost/noPriveleges.php');
        exit();
    }
}
?>