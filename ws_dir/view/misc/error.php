<?php
$error_code = -1;
$error_msg = "Une erreur est survenue";

if (isset($_GET["code"])) {
    $error_code = $_GET["code"];
}

if (isset($_GET["msg"])) {
    $error_msg = $_GET["msg"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur <?= $error_code ?></title>
</head>
<body>
    <h1>Erreur <?= $error_code ?></h1>
    <p><?= $error_msg ?></p>
    
</body>
</html>