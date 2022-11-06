<?php
    session_start();

    if(isset($_POST['login'])){
        $walidacja_udana = true;

        $login = $_POST['login'];
        $mail = $_POST['email'];
        $mail_bezpieczny = filter_var($mail, FILTER_SANITIZE_EMAIL);
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        $sprawdz_imie_nazwisko = '/(*UTF8)^[A-ZŁŚŻŹĆŃĄĘÓ]{1}+[a-ząęółśżźćń]+$/';


        if(strlen($login)<3 || strlen($login)>20){
            $walidacja_udana = false;
            $_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
        }
        if(!ctype_alnum($login)){
            $walidacja_udana = false;
            $_SESSION['e_login']="Login może składać się tylko z liter i cyfr(bez polskich znaków)";
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
            $_SESSION['e_regulamin']="Musisz zaakceptować nasz regulamin!";
        }
        
        $sekret = "6Lf1r9MiAAAAAEGtsJZMMOToW51pHi8Bp5tRhfW9";
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);
        if(!($odpowiedz->success)){
            $walidacja_udana = false;
            $_SESSION['e_captcha']="Potwierdź że nie jesteś botem!";
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

                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE nickname='$login'");
                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_rekordow = $rezultat->num_rows;
                if($ile_rekordow>0){
                    $walidacja_udana = false;
                    $_SESSION['e_login']="Istnieje już konto przypisane do tego loginu. Wybierz inny!";
                }

                if($walidacja_udana){
                    $zapytanie = "INSERT INTO uzytkownicy(nickname, imie, nazwisko, haslo, email) VALUES('$login','$imie', '$nazwisko', '$haslo_hash', '$mail');";
                    if($polaczenie->query($zapytanie)){
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
    }
?>


<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=2.0">
	<link rel="stylesheet" href="final2.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer>//CAPTCHA SCRIPT</script>
	<title>Test</title>
</head>
<body>
	<div id="RegisterArea">
		<form id="Register-form" method="POST">
			<p id="SignIn">Zarejstruj się</p>
			<div class="RegisterInput">
				<input type="text" name="imie" class="InputField" placeholder="Imie">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_imie'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_imie'].'</span>';
					unset($_SESSION['e_imie']);
				}
				?>
			</div>
			<div class="RegisterInput">
				<input type="text" name="nazwisko" class="InputField" placeholder="Nazwisko">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_nazwisko'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_nazwisko'].'</span>';
					unset($_SESSION['e_nazwisko']);
				}
				?>
			</div>
			<div class="RegisterInput">
				<input type="text" name="login" class="InputField" placeholder="Login">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_login'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_login'].'</span>';
					unset($_SESSION['e_login']);
				}
				?>
			</div>
			<div class="RegisterInput">
				<input type="text" name="email" class="InputField" placeholder="E-mail">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_email'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_email'].'</span>';
					unset($_SESSION['e_email']);
				}
				?>
			</div>
			<div class="RegisterInput">
				<input type="password" name="haslo1" class="InputField" placeholder="Hasło">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_haslo'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_haslo'].'</span>';
				}
				?>
			</div>
			<div class="RegisterInput">
				<input type="password" name="haslo2" class="InputField" placeholder="Powtórz Hasło">
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_haslo'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_haslo'].'</span>';
					unset($_SESSION['e_haslo']);
				}
				?>
			</div>	
			<div class="g-recaptcha" data-sitekey="6Lf1r9MiAAAAANavvJspmQqAFqn2Bfii-DMiUzOS"></div>	
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_captcha'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_captcha'].'</span>';
					unset($_SESSION['e_captcha']);
				}
				?>
			
			<label id="RegisterCheckBox">
				<input type="checkbox" name="regulamin" id="CheckBoxInput">
				Mam ukończone 18 lat i
				<a href="regulamin.html">akceptuje warunki i regulamin</a> użytkowania platformy Lights In
				<?php //WYŚWIETLENIE BŁĘDU
				if(isset($_SESSION['e_regulamin'])){
					echo '<span class="RegEx-check">'.$_SESSION['e_regulamin'].'</span>';
					unset($_SESSION['e_regulamin']);
				}
				?>	
			</label>
				
			<div id="RegisterBtn">
				<input type="submit" id="BtnInput" value="Zarejestruj się">
			</div>
			
		</form>
	</div>
</body>
</html>					
