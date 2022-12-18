<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(8);

if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "update":
            $_GET = escape_arr($connection, $_GET);
            $data = pg_fetch_all(pg_execute($connection, "update_filiation", array(intval($_GET["id"]),$_GET["address"],intval($_GET["boss_id"]))));
            header('Location: http://localhost/index.php?table=filiation');
            break;

    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Filiation form</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="shortcut icon" href="./favicon.ico" />
</head>
<body>
<?php
    include "header.php";
    ?>

    <?php
        if(isset($_GET["id"])){
            $data = pg_fetch_all(pg_execute($connection, "get_filiation", array(intval($_GET["id"]))));
            
            if (!isset($data[0])) {
                return '<tr><th>NO DATA FOUND</th></tr>';
            }

            $data=$data[0];
            echo '<div class="container"><form action="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" method="get">
                <input type="text" id="action" name="action" value="update" style="visibility:hidden;"><br><br>
                <input type="number" id="id" name="id" value="'.$data["id"].'" style="visibility:hidden;"><br><br>
                <label for="address">Filiation address:</label>
                <input type="text" id="address" name="address" value="'.$data["address"].'"><br><br>
                <label for="boss_id">Boss id:</label>
                <input type="text" type="number" id="boss_id" name="boss_id" value="'.$data['boss_id'].'"><br><br>
                <input type="submit" value="Submit">
            </form></div>';

        }
        pg_close($connection);
    ?>
</body>