<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(4);


if(isset($_POST["action"])){
    switch ($_POST["action"]) {
        case "insert":
            $_POST = escape_arr($connection, $_POST);
            $_POST["password"] = hash("sha256", $_POST["password"]);
            checkRights($_POST["rights"]);
            $result = pg_fetch_all(pg_execute($connection, "insert_workers", array($_POST["name"],$_POST["position"],
                                    $_POST["sallary"],$_POST["boss_id"],$_POST["filiation_id"],
                                    $_POST["login"],$_POST["password"], intval($_POST["rights"]))));
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

    <div class="container">
    <form action=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?> method="post">
        <input type="text" id="action" name="action" value="insert" style="visibility:hidden;"><br><br>
        <label for="name">Worker name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="sallary">Sallary:</label>
        <input type="number" id="sallary" name="sallary" step="0.01" ><br><br>
        <label for="position">Position:</label>
        <input type="text" id="position" name="position"><br><br>
        <label for="boss_id">Boss id:</label>
        <input type="number" id="boss_id" name="boss_id"><br><br>
        <label for="filiation_id">Filiation id:</label>
        <input type="number" id="filiation_id" name="filiation_id"><br><br>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login"><br><br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password"><br><br>
        <label for="rights">rights:</label>
        <input type="number" id="rights" name="rights"><br><br>
        <input type="submit" value="Submit">
    </form>
    </div>


    <?php
        pg_close($connection);
    ?>
	

</body>