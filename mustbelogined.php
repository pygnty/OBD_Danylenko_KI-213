<?php
    if(!isset($_COOKIE["login"])) 
        header('Location: http://localhost/login.php?error=Login%20please');
?>