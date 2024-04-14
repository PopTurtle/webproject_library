<?php

require_once "../autoloader.php";
use App\Model\Database;
use App\Model\DBObjects\Book;

$db = Database::getDatabase();

$b = new Book();

//var_dump($b);

$b->Author = "Auteur";
$b->Title = "Titre";
$b->Editor = "Editeur";
$b->PublicationYear = 1945;
$b->Category = "Roman";
$b->Stock = 3;

var_dump($b->Author);

$res = $b->tryAddToDB($db);
var_dump($res);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
</head>
<body>
    <h1>bibloték</h1>


</body>
</html>