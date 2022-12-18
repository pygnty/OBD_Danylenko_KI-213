<?php
unset($_COOKIE['login']); 
setcookie('login', 0, 1, '/'); 
unset($_COOKIE['rights']); 
setcookie('rights', 0, 1, '/'); 
header('Location: http://localhost');

?>