<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
require_once 'connect.php';

$pdo = new \PDO(DSN, USER, PASS);
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
    <?php 
        foreach ($friends as $friend): ?>
    <li><?= $friend["lastname"] . " " . $friend["firstname"] ?></li>
        <?php endforeach ?>
</ul>

<?php

$errors=[];

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
  
    if (empty($lastname)) {
        $errors[]="merci de rentrer une valeur";
    } elseif (strlen($lastname) > 45) {
        $errors[]="veuillez saisir un nom de moins de 45 caractères";
    }

    if (empty($firstname)){
        $errors[]="merci de rentrer une valeur";
    } elseif (strlen($firstname) > 45) {
        $errors[]="veuillez saisir un prénom de moins de 45 caractères";
    }

    if (empty($errors)) {
        $query='INSERT INTO friend (lastname, firstname) VALUES (:lastname, :firstname)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindValue(':firstname', $firstname,PDO::PARAM_STR);
        $statement->execute();
        $friends = $statement->fetchAll();
        header('Location: index.php');

    } else {

        echo implode("<br>",$errors);
    }
}

?>
<form action = "" method ="post">
    <input type="text" id="lastname" name ="lastname" value = "<?= htmlentities($friend['lastname']) ?>" required>
    <input type="text" id="firstname" name ="firstname" value = "<?= htmlentities($friend['firstname']) ?>"required>
    <button>sauvegarde</button>
</form>    
</body>
</html>
