<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(1);


if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "insert":
            $_GET = escape_arr($connection, $_GET);
            pg_execute($connection, "insert_clients", array($_GET["name"],$_GET["worker_id"]));
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
    <link rel="stylesheet" href="css/base.css">
    <link rel="shortcut icon" href="./favicon.ico" />
</head>
<body>
    <?php
    include "header.php";
    ?>

    <div class="container">
    <form action=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?> method="get">
        <input type="text" id="action" name="action" value="insert" style="visibility:hidden;"><br><br>
        <label for="name">Client name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="worker_id">Worker id:</label>
        <input type="number" id="worker_id" name="worker_id"><br><br>
        <input type="submit" value="Submit">
    </form>
    </div>
    <?php
        pg_close($connection);
    ?>
	

</body>