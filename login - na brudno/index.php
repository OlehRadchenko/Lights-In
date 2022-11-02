<?php
    session_start();
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']){
        header('Location: profil.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>
    <form action="zaloguj.php" method="post">
        Login:<input type="text" id="logina" name="login"><br>
        Hasło:<input type="password" id="password" name="haslo"><br><br>
        Nie posiadasz jeszcze konta? To możesz się <a href="rejestracja.php">zarejestrować</a><br>
        <input type="submit" value="Zaloguj się">
    </form>
    

    <?php
    if(isset($_SESSION['blad']))echo $_SESSION['blad'];
    ?>

</body>
</html>