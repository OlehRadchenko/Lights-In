<?php
    session_start();
    require_once "baza.php"; 

    if((!isset($_POST['login']) || !isset($_POST['haslo']))){
        header('Location: index.php');
        exit();
    }

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno;
    }else{
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        //$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
        
        //$zapytanie_sql = "SELECT * FROM uzytkownicy WHERE nickname='$login' AND haslo='$haslo'";

        if($rezultat = @$polaczenie->query(
        //$zapytanie_sql)
        sprintf("SELECT * FROM uzytkownicy WHERE nickname='%s'",
        mysqli_real_escape_string($polaczenie, $login)))){
            $ile_wierszy = $rezultat->num_rows;
            if($ile_wierszy>0){
                $wiersz = $rezultat->fetch_assoc();
                if(password_verify($haslo, $wiersz['haslo'])){
                    $_SESSION['zalogowany']=true;
                    
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['imie'] = $wiersz['imie'];
                    $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    $_SESSION['email'] = $wiersz['email'];
                    echo "Brawo, udało ci się zalogować. Zgadnę że twoje imie to: ".$imie.". A nazwisko: ".$nazwisko;
                    
                    unset($_SESSION['blad']);
                    $rezultat->close();
                    header('Location: profil.php');
                }else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowe hasło!</span>';
                    header('Location: index.php');
                }

            }else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
            }
        }else{
            echo "Jakaś literówka w zapytaniu 0_0";
        }

        $polaczenie->close();
    }

?>