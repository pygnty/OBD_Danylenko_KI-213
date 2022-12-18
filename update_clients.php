<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(1);

if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "update":
            $_GET = escape_arr($connection, $_GET);
            $data = pg_fetch_all(pg_execute($connection, "update_clients", array(intval($_GET["id"]),$_GET["name"],floatval($_GET["balance"]),intval($_GET["worker_id"]))));
            header('Location: http://localhost/index.php?table=clients');
            break;

    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clients form</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="shortcut icon" href="./favicon.ico" />
</head>
<body>
<?php
    include "header.php";
    ?>

    <?php
        if(isset($_GET["id"])){
            $data = pg_fetch_all(pg_execute($connection, "get_clients", array(intval($_GET["id"]))));
            
            if (!isset($data[0])) {
                return '<tr><th>NO DATA FOUND</th></tr>';
            }

            $data=$data[0];
            echo '<div class="container"><form action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" method="get">
                <input type="text" id="action" name="action" value="update" style="visibility:hidden;"><br><br>
                <input type="number" id="id" name="id" value="'.$data["id"].'" style="visibility:hidden;"><br><br>
                <label for="name">Client name:</label>
                <input type="text" id="name" name="name" value="'.$data["name"].'"><br><br>
                <label for="balance">Balance:</label>
                <input type="text" type="number" id="balance" name="balance" value="'.$data['balance'].'" step="0.01"><br><br>
                <label for="worker_id">Worker id:</label>
                <input type="number" value="'.$data["worker_id"].'" id="worker_id" name="worker_id"><br><br>
                <input type="submit" value="Submit">
            </form></div>';

        }
        pg_close($connection);
    ?>
</body>