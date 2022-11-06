<?php
    session_start();
    if(!isset($_SESSION['udana_rejestracja'])){
        header('Location: index.php');
        exit();
    }else{
        unset($_SESSION['udana_rejestracja']);
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
    Dziękujemy za rejestrację w naszym serwisie! Możesz <a href="index.html">zalogować się</a> na konto!
</body>
</html>