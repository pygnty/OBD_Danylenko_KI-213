<?php
include "mustbelogined.php";
include "connect.php";
include "functions.php";



if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "delete":
            global $tables;
            $data = pg_fetch_all(pg_execute($connection, "delete_" . $_GET["table"], array($_GET["id"])));
            header('Location: http://localhost/index.php?table='.$_GET["table"]);
            break;
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="shortcut icon" href="./favicon.ico" />
</head>
<body>
    <?php
    include "header.php";
    ?>
    <main>
    <?php
        if(isset($_GET["table"])){
            display_table($connection, $_GET["table"]);
            echo "<br><a href='insert_".$_GET["table"].".php'>Insert</a>";
        }

        pg_close($connection);
    ?>
    </main>

</body>