<?php
    session_start();
    require_once "baza.php"; 

    if((!isset($_POST['login']) || !isset($_POST['haslo']))){
        header('Location: SiteRegister.php');
        exit();
    }

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno;
    }else{
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE nickname='%s'", mysqli_real_escape_string($polaczenie, $login)))){
            $ile_wierszy = $rezultat->num_rows;
            if($ile_wierszy>0){
                $wiersz = $rezultat->fetch_assoc();
                if(password_verify($haslo, $wiersz['haslo'])){
                    $_SESSION['zalogowany']=true;
                    
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['nick'] = $wiersz['nickname'];
                    $_SESSION['imie'] = $wiersz['imie'];
                    $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    $_SESSION['email'] = $wiersz['email'];
                    
                    unset($_SESSION['blad']);
                    $rezultat->close();
                    header('Location: profil.php');
                }else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowe hasło!</span>';
                    header('Location: SiteRegister.php');
                }
            }else if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE email='%s'", mysqli_real_escape_string($polaczenie, $login)))){
                $ile_wierszy = $rezultat->num_rows;
            if($ile_wierszy>0){
                $wiersz = $rezultat->fetch_assoc();
                if(password_verify($haslo, $wiersz['haslo'])){
                    $_SESSION['zalogowany']=true;
                    
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['imie'] = $wiersz['imie'];
                    $_SESSION['nick'] = $wiersz['nickname'];
                    $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    $_SESSION['email'] = $wiersz['email'];
                    
                    unset($_SESSION['blad']);
                    $rezultat->close();
                    header('Location: profil.php');
                }else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowe hasło!</span>';
                    header('Location: SiteRegister.php');
                }
            }else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: SiteRegister.php');
            }
            
        }else{
            echo "Jakaś literówka w zapytaniu 0_0"; //INFO DLA DEVELOPERÓW
        }

        $polaczenie->close();
    }
}

?>