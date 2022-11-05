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
    $imie = $_SESSION['imie'];
    $nazwisko = $_SESSION['nazwisko'];
    $email = $_SESSION['email'];
    echo "Brawo, udało ci się zalogować. Zgadnę że twoje imie to: ".$imie.". A nazwisko: ".$nazwisko."<br>";
    echo "Twój email to: ".$email.". Chcesz go zmienić?<br><a href='wyloguj.php'>Wyloguj się</a>";
    ?>

</body>
</html>