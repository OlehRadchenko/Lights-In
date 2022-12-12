<?php
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: zaloguj_musisz.html');
        exit();
    }

    if(isset($_POST['elektryk'])){
        $mozna_zerejestrowac = true;
        $id_uzytkownika = $_SESSION['id'];
        $id_elektryka=$_POST['elektryk'];
        $data_wizyty = $_POST['dzien'];
        $opis_problemu = $_POST['opis'];
        
        if(strlen($opis_problemu)<10 || strlen($opis_problemu)>1000){
            $mozna_zerejestrowac = false;
            $_SESSION['e_opis']="Opis musi posiadać od 10 do 1000 znaków!";
        }

        $sekret = "6Lf1r9MiAAAAAEGtsJZMMOToW51pHi8Bp5tRhfW9";
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);
        if(!($odpowiedz->success)){
            $mozna_zerejestrowac = false;
            $_SESSION['e_captcha']="Potwierdź że nie jesteś botem!";
        }

        require_once 'baza.php';

        try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else{
                if($rezultat = @$polaczenie->query("SELECT * FROM wizyty WHERE Data_wizyty='$data_wizyty' AND ID_elektryka='$id_elektryka'")){
                    $ile_wierszy = $rezultat->num_rows;
                    if($ile_wierszy>0){
                        $mozna_zerejestrowac = false;
                        $_SESSION['e_data']="<br>Dana wizyta już jest zarezerwowana przez innego użytkownika, wybierz inny termin!";
                    }else{
                        if($mozna_zerejestrowac){
                            $zapytanie = "INSERT INTO wizyty(ID_elektryka, ID_uzytkownika, Data_wizyty, Opis_problemu) VALUES('$id_elektryka','$id_uzytkownika', '$data_wizyty', '$opis_problemu');";
                            if($polaczenie->query($zapytanie)){
                                header('Location: dzieki.html');
                            }else{
                                throw new Exception($polaczenie->error);
                            }
                        }
        
                        $polaczenie->close();
                    }
                }else{
                    echo "Jakaś literówka w zapytaniu 0_0"; //INFO DLA DEVELOPERÓW
                }
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
    <script src="https://www.google.com/recaptcha/api.js" async defer>//CAPTCHA SCRIPT</script>
    <title>Lights In | Rejestracja wizyty</title>

</head>
<body>
    <form method="POST">
        Wybierz elektryka do którego chcesz trafić: 
        <select name="elektryk">
            <option value="1">Michał Jóźwiak</option>
            <option value="2">Justyn Bielawski</option>
            <option value="3">Szymon Gawroński</option>
            <option value="4">Emil Matuszak</option>
            <option value="5">Paweł Kalisz</option>
        </select>
        <br>
        Wybierz czas na który chcesz mieć wizytę:
        <select name="dzien">
            <?php
                $przerwa_miedzy_wizytami = 3; //w minutach/10
                $now = new DateTime();

                $dzien = $now->format("Y-m-d");
                $dzien2 = date('Y-m-d', strtotime($dzien.' +1 day' ));
                $godzina = $now->format("H");
                $minuta = $now->format("i");
                if($minuta>0 && $minuta <30){
                    $minuta = 3;
                }else if($minuta>30 && $minuta<60){
                    $minuta = 0;
                    $godzina++;
                }
                
                for($i=0; $godzina<17; $i++){
                    if($minuta==6){
                        $godzina++;
                        $minuta=0;
                    }
                    echo '<option value="'.$dzien.' '.$godzina.':'.$minuta.'0">'.$dzien.' '.$godzina.':'.$minuta.'0</option>';
                    $minuta+=$przerwa_miedzy_wizytami;
                }
                $godzina = 12;
                $minuta = 0;
                for($i=0; $godzina<17; $i++){
                    if($minuta==6){
                        $godzina++;
                        $minuta=0;
                    }
                    echo '<option value="'.$dzien2.' '.$godzina.':'.$minuta.'0">'.$dzien2.' '.$godzina.':'.$minuta.'0</option>';
                    $minuta+=$przerwa_miedzy_wizytami;
                }
            ?>
        </select>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_data'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_data'].'</span><br><br>';
                unset($_SESSION['e_data']);
            }
        ?>
        <br>
        Opis twojego problemu: <input type="text" name="opis"><br>
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_opis'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_opis'].'</span><br><br>';
                unset($_SESSION['e_opis']);
            }
        ?>
        <br>
        <div class="g-recaptcha" data-sitekey="6Lf1r9MiAAAAANavvJspmQqAFqn2Bfii-DMiUzOS"></div>	
        <?php //WYŚWIETLENIE BŁĘDU
            if(isset($_SESSION['e_captcha'])){
                echo '<span class="RegEx-check">'.$_SESSION['e_captcha'].'</span>';
                unset($_SESSION['e_captcha']);
            }
        ?>
        <br>
        <input type="submit" value="Wyślij">
        <br>
        <a href="index.php">Powrót do strony głównej</a>
    </form>


</body>
</html>