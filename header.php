<header class="header">
    <?php
if (isset($_COOKIE["rights"]) && (intval($_COOKIE["rights"]) & 1))
    echo '<a href="index.php?table=clients">Clients</a>';
if (isset($_COOKIE["rights"]) && (intval($_COOKIE["rights"]) & 8))
    echo '<a href="index.php?table=filiation">Filiation</a>';
if (isset($_COOKIE["rights"]) && (intval($_COOKIE["rights"]) & 4))
    echo '<a href="index.php?table=workers">Workers</a>';
if (isset($_COOKIE["rights"]) && (intval($_COOKIE["rights"]) & 2))
    echo '<a href="index.php?table=transactions">Transactions</a>';
?>
<a style="float:left;" href="exit.php">Exit</a>
</header>