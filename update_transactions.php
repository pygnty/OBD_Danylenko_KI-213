<?php
include "connect.php";
include "functions.php";
include "mustbelogined.php";
include "mustbepriveleged.php";
gerarahere(16);


if(isset($_POST["action"])){
    switch ($_POST["action"]) {
        case "update":
            $_POST = escape_arr($connection, $_POST);
            pg_fetch_all(pg_execute($connection, "update_transactions", array($_POST["sender_id"],$_POST["recipient_id"],
                                                                            $_POST["amount"],$_POST["comment"])));
            header('Location: http://localhost/index.php?table=transactions');
            break;

    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transactions form</title>
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
        <?php 
        $clients = pg_fetch_all(pg_execute($connection, "display_table_clients", array(100,0)));
        ?>
        <label for="sender_id">Sender:</label>
        <select name="sender_id" id="sender_id">
            <?php
            foreach ($clients as $client) {
                echo " <option value='{$client['id']}'>{$client['name']}</option>";
            }
            ?>
        </select>
        <label for="recipient_id">recipient:</label>
        <select name="recipient_id" id="recipient_id">
        <?php
            foreach ($clients as $client) {
            echo " <option value='{$client['id']}'>{$client['name']}</option>";
            }
            ?>
        </select>
        
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" min="0" ><br><br>
        <label for="comment">Comment:</label>
        <input type="text" id="comment" name="comment"><br><br>
        <input type="submit" value="Submit">
    </form>
    </div>


    <?php
        pg_close($connection);
    ?>
	

</body>