<?php
    session_start();

    if(isset($_POST['nick'])){
        $walidacja_udana = true;

        $nick = $_POST['nick'];
        $mail = $_POST['email'];
        $mail_bezpieczny = filter_var($mail, FILTER_SANITIZE_EMAIL);
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        $sprawdz_imie_nazwisko = '/(*UTF8)^[A-ZŁŚŻŹĆŃĄĘÓ]{1}+[a-ząęółśżźćń]+$/';


        if(strlen($nick)<3 || strlen($nick)>20){
            $walidacja_udana = false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
        }
        if(!ctype_alnum($nick)){
            $walidacja_udana = false;
            $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr(bez polskich znaków)";
        }

        if(!filter_var($mail_bezpieczny, FILTER_VALIDATE_EMAIL) || $mail!=$mail_bezpieczny){
            $walidacja_udana = false;
            $_SESSION['e_email']="Podaj poprawny adres email!";
        }

        if(!preg_match($sprawdz_imie_nazwisko, $imie)){
            $walidacja_udana = false;
            $_SESSION['e_imie']="Imie musi zawierać jedną dużą literę";
        }
        if(strlen($imie)<2 || strlen($imie)>20){
            $walidacja_udana = false;
            $_SESSION['e_imie']="Imie musi posiadać od 2 do 20 znaków!";
        }

        if(!preg_match($sprawdz_imie_nazwisko, $nazwisko)){
            $walidacja_udana = false;
            $_SESSION['e_nazwisko']="Nazwisko musi zawierać jedną dużą literę";
        }
        if(strlen($nazwisko)<2 || strlen($nazwisko)>20){
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
            $_SESSION['e_regulamin']="Musisz zaakceptować nasz regulamin :<!";
        }
        
        $sekret = "6Lf1r9MiAAAAAEGtsJZMMOToW51pHi8Bp5tRhfW9";
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);
        if(!($odpowiedz->success)){
            $walidacja_udana = false;
            $_SESSION['e_captcha']="Potwierdź że nie jesteś botem :<!";
        }

        require_once 'baza.php';
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else{
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$mail'");
                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_rekordow = $rezultat->num_rows;
                if($ile_rekordow>0){
                    $walidacja_udana = false;
                    $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email!";
                }

                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE nickname='$nick'");
                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_rekordow = $rezultat->num_rows;
                if($ile_rekordow>0){
                    $walidacja_udana = false;
                    $_SESSION['e_nick']="Istnieje już konto przypisane do tego loginu(nickname'u). Wybierz inny!";
                }

                if($walidacja_udana){
                    $zapytanie = "INSERT INTO uzytkownicy(nickname, imie, nazwisko, haslo, email) VALUES('$nick','$imie', '$nazwisko', '$haslo_hash', '$mail');";
                    if($polaczenie->query($zapytanie)){
                        //$rezultat = $polaczenie->query($zapytanie);
                        $_SESSION['udana_rejestracja']=true;
                        header('Location: witam.php');
                    }else{
                        throw new Exception($polaczenie->error);
                    }
                }

                $polaczenie->close();
            }
        }catch(Exception $e){
            echo '<div class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</div>';
            //echo "<br>Informacja developerska: ".$e;
        }

        if($walidacja_udana){
            require_once 'baza.php';
            mysqli_report(MYSQLI_REPORT_STRICT);
            try{
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if($polaczenie->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                }else{
                    $zapytanie = "INSERT INTO uzytkownicy(nickname, imie, nazwisko, haslo, email) VALUES('$nick','$imie', '$nazwisko', '$haslo_hash', '$mail');";
                    $rezultat = $polaczenie->query($zapytanie);
                }
            }catch(Exception $e){
                echo '<div class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</div>';
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
    <title>TEST</title>
    <style>
        .error{
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        p{
            color: black;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form method="post" id="rejestracja">
        E-mail:<input type="text" name="email"><br>
        <?php
        if(isset($_SESSION['e_email'])){
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
        ?>
        Login(nickname):<input type="text" name="nick"><br>
        <?php
        if(isset($_SESSION['e_nick'])){
            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
        }
        ?>
        Imie:<input type="text" name="imie"><br>
        <?php
        if(isset($_SESSION['e_imie'])){
            echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
            unset($_SESSION['e_imie']);
        }
        ?>
        Nazwisko:<input type="text" name="nazwisko"><br>
        <?php
        if(isset($_SESSION['e_nazwisko'])){
            echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
            unset($_SESSION['e_nazwisko']);
        }
        ?>
        Hasło:<input type="password" name="haslo1"><br>
        Powtórz hasło:<input type="password" name="haslo2"><br>
        <?php
        if(isset($_SESSION['e_haslo'])){
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }
        ?>
        <label><input type="checkbox" name="regulamin"> Akceptuję </label><a href="regulamin.html">regulamin</a>
        <?php
        if(isset($_SESSION['e_regulamin'])){
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
        ?>
        <div class="g-recaptcha" data-sitekey="6Lf1r9MiAAAAANavvJspmQqAFqn2Bfii-DMiUzOS"></div>
        <?php
        if(isset($_SESSION['e_captcha'])){
            echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
            unset($_SESSION['e_captcha']);
        }
        ?>
        <br><input type="submit" value="Zarejestruj się"><br>
        <p>Posiadasz już konto? To możesz się <a href="index.php">zalogować</a><br></p>
    </form>
</body>
</html>