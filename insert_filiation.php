<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(8);


if(isset($_GET["action"])){
    switch ($_GET["action"]) {
        case "insert":
            $_GET = escape_arr($connection, $_GET);
            pg_execute($connection, "insert_filiation", array($_GET["address"],$_GET["boss_id"]));
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

    <div class="container">
    <form action=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?> method="get">
        <input type="text" id="action" name="action" value="insert" style="visibility:hidden;"><br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address"><br><br>
        <label for="boss_id">Boss id:</label>
        <input type="text" id="boss_id" name="boss_id"><br><br>
        <input type="submit" value="Submit">
    </form>
    </div>


    <?php
        pg_close($connection);
    ?>
	

</body>