<?php
    session_start();

    if(isset($_POST['imie'])){
        $walidacja_udana = true;

        $mail = $_POST['mail'];
        $mail_bezpieczny = filter_var($mail, FILTER_SANITIZE_EMAIL);
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $nr_tel = $_POST['numer_tel'];
        $wiadomosc = $_POST['wiadomosc'];
        $sprawdz_nr_tel = '/^\+48{1}+[0-9]{9}/';
        $sprawdz_nr_tel2 = '/^[0-9]{9}/';
        $sprawdz_imie_nazwisko = '/(*UTF8)^[A-ZŁŚŻŹĆŃĄĘÓ]{1}+[a-ząęółśżźćń]+$/';

        if((!preg_match($sprawdz_nr_tel2, $nr_tel) && strlen($nr_tel)!=12) || (!preg_match($sprawdz_nr_tel, $nr_tel) && strlen($nr_tel)!=9)){
            $walidacja_udana = false;
            $_SESSION['e_nr_tel']="Podaj poprawny numer telefonu!";
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

        if(strlen($wiadomosc)<10 || strlen($wiadomosc)>1000){
            $walidacja_udana = false;
            $_SESSION['e_wiadomosc']="Wiadomość musi posiadać od 10 do 1000 znaków!";
        }

        require_once 'baza.php';
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else{
                if($walidacja_udana){
                    $zapytanie = "INSERT INTO wspolpraca(imie, nazwisko, email, nr_tel, wiadomosc) VALUES('$imie', '$nazwisko', '$mail', '$nr_tel', '$wiadomosc');";
                    if($polaczenie->query($zapytanie)){
                        header('Location: dzieki.html');
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
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIGHTS IN | USŁUGI ELEKTRYCZNE</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/427/427735.png">
</head>
<body>
    <form method="POST">
        Imie: <input type="text" name="imie"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_imie'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_imie'].'</span><br><br>';
                unset($_SESSION['e_imie']);
            }
        ?>
        Nazwisko: <input type="text" name="nazwisko"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_nazwisko'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_nazwisko'].'</span><br><br>';
                unset($_SESSION['e_nazwisko']);
            }
        ?>
        Adres e-mail: <input type="email" name="mail"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_email'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_email'].'</span><br><br>';
                unset($_SESSION['e_email']);
            }
        ?>
        Numer telefonu: <input type="text" name="numer_tel"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_nr_tel'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_nr_tel'].'</span><br><br>';
                unset($_SESSION['e_nr_tel']);
            }
        ?>
        Wiadomość: <input type="text" name="wiadomosc"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_wiadomosc'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_wiadomosc'].'</span><br><br>';
                unset($_SESSION['e_wiadomosc']);
            }
        ?>
        <br><br>
        <input type="submit" value="Wyślij">
        <br>
        <a href="index.php">Powrót do strony głównej</a>
    </form>
</body>
</html>