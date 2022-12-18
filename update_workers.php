<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(4);

if(isset($_POST["action"])){
    switch ($_POST["action"]) {
        case "update":
            $_POST = escape_arr($connection, $_POST);
            $_POST["password"] = hash("sha256", $_POST["password"]);
            checkRights($_POST["rights"]);
            $_POST = escape_arr($connection, $_POST);
            $data = pg_fetch_all(pg_execute($connection, "update_workers", array(intval($_GET["id"]),$_GET["name"],floatval($_GET['sallary']),$_GET['position'],intval($_GET["boss_id"]),intval($_GET["filiation_id"]))));
            header('Location: http://localhost/index.php?table=workers');
            break;

    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Workers form</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="shortcut icon" href="./favicon.ico" />
</head>
<body>
    <?php
    include "header.php";
    ?>

    <?php
        if(isset($_GET["id"])){
            $data = pg_fetch_all(pg_execute($connection, "get_workers", array(intval($_GET["id"]))));
            
            if (!isset($data[0])) {
                return '<tr><th>NO DATA FOUND</th></tr>';
            }

            $data=$data[0];
            echo '<div class="container"><form action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" method="post">
                <input type="text" id="action" name="action" value="update" style="visibility:hidden;"><br><br>
                <input type="number" id="id" name="id" value="'.$data["id"].'" style="visibility:hidden;"><br><br>
                <label for="name">Worker name:</label>
                <input type="text" id="name" name="name" value="'.$data["name"].'"><br><br>
                <label for="sallary">Sallary:</label>
                <input type="number" id="sallary" name="sallary" value="'.$data['sallary'].'" step="0.01"><br><br>
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" value="'.$data['position'].'"><br><br>
                <label for="boss_id">Boss id:</label>
                <input type="text" type="number" id="boss_id" name="boss_id" value="'.$data['boss_id'].'"><br><br>
                <label for="filiation_id">Filiation id:</label>
                <input type="text" type="number" id="filiation_id" name="filiation_id" value="'.$data['filiation_id'].'"><br><br>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" value="'.$data['login'].'"><br><br>
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" value="'.$data['password'].'"><br><br>
                <label for="rights">rights:</label>
                <input type="number" id="rights" name="rights" value="'.$data['rights'].'"><br><br>
                <input type="submit" value="Submit">
            </form></div>';

        }
        pg_close($connection);
    ?>
</body>