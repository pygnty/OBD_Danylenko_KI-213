<?php
include "connect.php";
include "functions.php";

if (isset($_COOKIE["login"])) {
    header('Location: http://localhost/index.php');

}

if (isset($_POST["login"]) && isset($_POST["password"])) {
    $params = $_POST;
    $params["login"] = preg_replace("/[^a-zA-Z]/", "", $params["login"]);
    $params["password"] = hash("sha256", $params["password"]);
    $params = escape_arr($connection, $params);
    $data = pg_fetch_all(pg_execute($connection, "login", array($params["login"], $params["password"])));
    if (!isset($data) || !isset($data[0]) || !isset($data[0]["hash"])) {
        header('Location: http://localhost/login.php?error=Wrong%20login%20or%20password');
    }
    setcookie("login", $data[0]["hash"], time() + (86400 * 30), "/");
    setcookie("rights", intval($data[0]["rights"]), time() + (86400 * 30), "/");
    header('Location: http://localhost/index.php');
}
?>

<!DOCTYPE html>

<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div class="row">
        <div class="colm-form">
            <div class="form-container">
                    <form action="login.php" method="post">
                            <h2>LOGIN</h2>
                    <?php if (isset($_GET['error'])) { ?>
                                <p class="error">
                        <?php echo $_GET['error']; ?>
                    </p>     
                    <?php } ?>
                            <input type="text" name="login" placeholder="login"><br>
                            <input type="password" name="password" placeholder="Password"><br> 
                            <button class="btn-login" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>