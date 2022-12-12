<?php
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }else{
        $id = $_SESSION['id'];
        $nick = $_SESSION['nick'];
        $imie = $_SESSION['imie'];
        $nazwisko = $_SESSION['nazwisko'];
        $email = $_SESSION['email'];

        if(isset($_POST['nick'])){
            $walidacja_udana = true;
    
            if(!empty($_POST['nick'])){
                $nowy_nick = $_POST['nick'];
            }else{
                $nowy_nick = $nick;
            }

            if(!empty($_POST['email'])){
                $nowy_mail = $_POST['email'];
            }else{
                $nowy_mail = $email;
            }

            if(!empty($_POST['imie'])){
                $nowy_imie = $_POST['imie'];
            }else{
                $nowy_imie = $imie;
            }

            if(!empty($_POST['nazwisko'])){
                $nowy_nazwisko = $_POST['nazwisko'];
            }else{
                $nowy_nazwisko = $nazwisko;
            } 

            if(!empty($_POST['haslo1']) && !empty($_POST['haslo2'])){
                $haslo1 = $_POST['haslo1'];
                $haslo2 = $_POST['haslo2'];
            }else{
                $haslo1 = $_POST['haslo_wer'];
                $haslo2 = $_POST['haslo_wer'];
            } 
            
            $mail_bezpieczny = filter_var($nowy_mail, FILTER_SANITIZE_EMAIL);
            $haslo_wer = $_POST['haslo_wer'];
            $sprawdz_imie_nazwisko = '/(*UTF8)^[A-ZŁŚŻŹĆŃĄĘÓ]{1}+[a-ząęółśżźćń]+$/';
    
    
            if(strlen($nowy_nick)<3 || strlen($nowy_nick)>20){
                $walidacja_udana = false;
                $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
            }
            if(!ctype_alnum($nowy_nick)){
                $walidacja_udana = false;
                $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr(bez polskich znaków)";
            }
    
            if(!filter_var($mail_bezpieczny, FILTER_VALIDATE_EMAIL) || $nowy_mail!=$mail_bezpieczny){
                $walidacja_udana = false;
                $_SESSION['e_email']="Podaj poprawny adres email!";
            }
    
            if(!preg_match($sprawdz_imie_nazwisko, $nowy_imie)){
                $walidacja_udana = false;
                $_SESSION['e_imie']="Imie musi zawierać jedną dużą literę";
            }
            if(strlen($nowy_imie)<2 || strlen($nowy_imie)>20){
                $walidacja_udana = false;
                $_SESSION['e_imie']="Imie musi posiadać od 2 do 20 znaków!";
            }
    
            if(!preg_match($sprawdz_imie_nazwisko, $nowy_nazwisko)){
                $walidacja_udana = false;
                $_SESSION['e_nazwisko']="Nazwisko musi zawierać jedną dużą literę";
            }
            if(strlen($nowy_nazwisko)<2 || strlen($nowy_nazwisko)>20){
                $walidacja_udana = false;
                $_SESSION['e_nazwisko']="Nazwisko musi posiadać od 2 do 30 znaków!";
            }
    
            if(!$haslo1==$haslo2){
                $walidacja_udana = false;
                $_SESSION['e_haslo']="Hasła nie są jednakowe";
            }else if(strlen($haslo1)<8 || strlen($haslo1)>20){
                $walidacja_udana = false;
                $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 30 znaków!";
            }else{
                $haslo_hash = password_hash($haslo1 ,PASSWORD_DEFAULT);
            }
    
            if(!isset($_POST['regulamin'])){
                $walidacja_udana = false;
                $_SESSION['e_regulamin']="Musisz zaakceptować nasz regulamin :c!";
            }
            
            
            $sekret = "6Lf1r9MiAAAAAEGtsJZMMOToW51pHi8Bp5tRhfW9";
            $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
            $odpowiedz = json_decode($sprawdz);
            if(!($odpowiedz->success)){
                $walidacja_udana = false;
                $_SESSION['e_captcha']="Potwierdź że nie jesteś botem :c!";
            }
    
            require_once 'baza.php';
            mysqli_report(MYSQLI_REPORT_STRICT);
            try{
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if($polaczenie->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                }else{
                    $zapytanie = "SELECT * FROM uzytkownicy WHERE email='$email'";
                    $rezultat = $polaczenie->query($zapytanie);
                    if($rezultat){
                        $wiersz = $rezultat->fetch_assoc();
                        $haslo_uzytkownika = $wiersz['haslo'];
                        $rezultat->close();
                    }

                    if(password_verify($haslo_wer, $haslo_uzytkownika)){

                    }else{
                        $walidacja_udana = false;
                        $_SESSION['e_haslo_wer']="Wprowadziłeś niepoprawne hasło";
                    }
                    

                    if($walidacja_udana){
                        $zapytanie = "UPDATE uzytkownicy SET nickname='$nowy_nick', imie='$nowy_imie', nazwisko='$nowy_nazwisko', haslo='$haslo_hash', email='$nowy_mail' WHERE id='$id';";
                        if($polaczenie->query($zapytanie)){
                            $zapytanie2 = "SELECT * FROM uzytkownicy WHERE id='$id';";
                            $rezultat = $polaczenie->query($zapytanie2);
                            $wiersz = $rezultat->fetch_assoc();
                            $_SESSION['id'] = $wiersz['id'];
                            $_SESSION['imie'] = $wiersz['imie'];
                            $_SESSION['nick'] = $wiersz['nickname'];
                            $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                            $_SESSION['email'] = $wiersz['email'];
                            $rezultat->close();
                            echo 'Udało się zmienić dane. <a href="profil.php">Wejdź na profil</a>';
                            //header('Location: witam.php');
                        }else{
                            throw new Exception($polaczenie->error);
                        }
                    }
    
                    $polaczenie->close();
                }
            }catch(Exception $e){
                echo '<div class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o edycje w innym terminie!</div>';
                //echo "<br>Informacja developerska: ".$e;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer>//CAPTCHA SCRIPT</script>
    <title>Edycja profilu użytkownika</title>
    <style>
        input{
            width: 20%;
        }
    </style>
</head>
<body>
    <form method="POST">
    <?php
    echo 'Adres e-mail:<input type="text" name="email" placeholder="Podaj nowy email, stary to: '.$email.'"><br>';
    if(isset($_SESSION['e_email'])){
        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);
    }

    echo 'Login(nickname):<input type="text" name="nick" placeholder="Podaj nowy login(nickname), stary to: '.$nick.'"><br>';
    if(isset($_SESSION['e_nick'])){
        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
        unset($_SESSION['e_nick']);
    }

    echo 'Imie:<input type="text" name="imie" placeholder="Podaj nowe imie, stare to: '.$imie.'"><br>';
    if(isset($_SESSION['e_imie'])){
        echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
        unset($_SESSION['e_imie']);
    }

    echo 'Nazwisko:<input type="text" name="nazwisko" placeholder="Podaj nowe nazwisko, stare to: '.$nazwisko.'"><br>';
    if(isset($_SESSION['e_nazwisko'])){
        echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
        unset($_SESSION['e_nazwisko']);
    }

    echo 'Hasło:<input type="password" name="haslo1" placeholder="Podaj nowe hasło"><br>Powtórz nowe hasło:<input type="password" name="haslo2" placeholder="Powtórz nowe hasło"><br>';
    if(isset($_SESSION['e_haslo'])){
        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
        unset($_SESSION['e_haslo']);
    }

    echo '<label><input type="checkbox" name="regulamin"> Akceptuję </label><a href="regulamin.html">regulamin</a>';
    if(isset($_SESSION['e_regulamin'])){
        echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
        unset($_SESSION['e_regulamin']);
    }

    echo '<br>Hasło:<input type="password" name="haslo_wer" placeholder="Wprowadź stare hasło">';
    if(isset($_SESSION['e_haslo_wer'])){
        echo '<div class="error">'.$_SESSION['e_haslo_wer'].'</div>';
        unset($_SESSION['e_haslo_wer']);
    }
    ?>
    <br><br>
    <div class="g-recaptcha" data-sitekey="6Lf1r9MiAAAAANavvJspmQqAFqn2Bfii-DMiUzOS"></div>
    <?php
        if(isset($_SESSION['e_captcha'])){
            echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
            unset($_SESSION['e_captcha']);
        }
    ?>
    <br><input type="submit" value="Zmień dane"><br>

    </form>
    <a href="index.php">Wróc do strony głównej</a>
</body>
</html>