<?php
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
</head>
<body>
    <?php
    $nick = $_SESSION['nick'];
    $imie = $_SESSION['imie'];
    $nazwisko = $_SESSION['nazwisko'];
    $email = $_SESSION['email'];
    echo "Nick: ".$nick."<br>Imie: ".$imie."<br>Nazwisko: ".$nazwisko."<br>Adres e-mail: ".$email;
    ?>
    <br><a href="index.php">Powrót na stronę główną</a>

</body>
</html>