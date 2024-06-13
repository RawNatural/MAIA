<?php
if (session_id() === "") {
    session_start();
}
$_SESSION['lastPage'] = $_SERVER['PHP_SELF'];


?>

<!DOCTYPE html>

<html lang="en">

<head>
        <title>Maia</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="maia.css">
    <?php
foreach ($scriptList as $script) {
    echo "<script src='$script'></script>";
}



?>
</head>


        <header id="maiaHeader">
            <a href="index.php"><h1 id="MaiaTitle">MAIA</h1></a>

            <?php include("nav.php");?>


        </header>
<body>
