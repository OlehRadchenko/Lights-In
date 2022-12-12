<?php
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: FormSite.php');
    }else{
        if(isset($_POST['mail'])){
            $walidacja_udana = true;
    
            $mail = $_POST['mail'];
            $mail_bezpieczny = filter_var($mail, FILTER_SANITIZE_EMAIL);
            $tema = $_POST['tema'];
            $opis = $_POST['opis'];
            $sprawdz_nr_tel = '/^\+48{1}+[0-9]{9}/';
            $sprawdz_nr_tel2 = '/^[0-9]{9}/';
            if(!empty($_POST["numer_tel"])){
                $nr_tel = $_POST['numer_tel'];
                if((!preg_match($sprawdz_nr_tel2, $nr_tel) && strlen($nr_tel)!=12) || (!preg_match($sprawdz_nr_tel, $nr_tel) && strlen($nr_tel)!=9)){
                    $walidacja_udana = false;
                    $_SESSION['e_nr_tel']="Podaj poprawny numer telefonu!";
                }
            }else{
                $nr_tel = NULL;
            }
            
    
            if(!filter_var($mail_bezpieczny, FILTER_VALIDATE_EMAIL) || $mail!=$mail_bezpieczny){
                $walidacja_udana = false;
                $_SESSION['e_email']="Podaj poprawny adres email!";
            }
    
            if(strlen($tema)<5 || strlen($tema)>100){
                $walidacja_udana = false;
                $_SESSION['e_tema']="Temat musi posiadać od 5 do 100 znaków!";
            }
    
            if(strlen($opis)<strlen($tema)+1 || strlen($opis)>1000){
                $walidacja_udana = false;
                $_SESSION['e_opis']="Opis musi posiadać od ".strlen($tema)." do 1000 znaków!";
            }
    
            require_once 'baza.php';
            mysqli_report(MYSQLI_REPORT_STRICT);
            try{
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if($polaczenie->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                }else{
                    if($walidacja_udana){
                        $zapytanie = "INSERT INTO zgloszenia_problemow(email_kontaktowy, temat, opis, nr_tel_kontaktowego) VALUES('$mail', '$tema', '$opis', '$nr_tel');";
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
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="FormStyle.css">
    <title>LIGHTS IN | USŁUGI ELEKTRYCZNE</title>
    <script src="Mainscript.js" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/427/427735.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  

</head>
<body>
<header>
            <div id="HeaderNav-banner">
                <div id="HeaderNav-foldMenu">
                    <button class="hamburger">
                        <span class="hamburger_box">
                            <span class="hamburger_inner"></span>
                        </span>
                    </button>
                    <div id="navi" class="navigation">
                        <ul class="navigation_list">
                            <li class="navigation_item"><iconify-icon icon="clarity:home-line" width="30" height="30"></iconify-icon><a href="index.php">Home</a></li>
                            <li class="navigation_item"><iconify-icon icon="clarity:shopping-bag-line" width="30" height="30"></iconify-icon><a href="wizyty.php">Wizyta</a></li>
                            <li class="navigation_item"><iconify-icon icon="clarity:lightbulb-line" width="30" height="30"></iconify-icon><a href="FormSite.php">Zgłoś Problem</a></li>
                            <li class="navigation_item"><iconify-icon icon="material-symbols:handshake-sharp" width="30" height="30"></iconify-icon><a href="wspolpraca.php">Dołącz do nas</a></li>
                        </ul>
                    </div>
                </div>
                <div id="HeaderNav-logo">           
                    <img
                        src="SiteAddons/Lightbulb-logo.png"
                        alt="Logo">
                    <a href="index.php">Lights <br> In</a> 
                </div>
            </div>
    </header>
    <section>
        <form method="POST">
            <div class="formContainer">
                <div class="form">
                <p>Opisz nam swój problem(* - pole obowiązkowe)</p>
                    <label for="email__input">E-mail*</label>
                    <input type="text" name="mail" class="input" id="email__input">
                    <?php //WYŚWIETLENIE BŁĘDU
                        if(isset($_SESSION['e_email'])){
                            echo '<span class="RegEx-check" style="color:white;">'.$_SESSION['e_email'].'</span><br><br>';
                            unset($_SESSION['e_email']);
                        }
                    ?>

                    <label for="temat__input">Temat*</label>
                    <input type="text" name="tema" class="input" id="email__input">
                    <?php //WYŚWIETLENIE BŁĘDU
                        if(isset($_SESSION['e_tema'])){
                            echo '<span class="RegEx-check" style="color:white;">'.$_SESSION['e_tema'].'</span><br><br>';
                            unset($_SESSION['e_tema']);
                        }
                    ?>

                    <label for="opis__input">Opis*</label>
                    <textarea name="opis" id="temat__input" class="input2" cols="30" rows="10"></textarea>
                    <?php //WYŚWIETLENIE BŁĘDU
                        if(isset($_SESSION['e_opis'])){
                            echo '<span class="RegEx-check" style="color:white;">'.$_SESSION['e_opis'].'</span><br><br>';
                            unset($_SESSION['e_opis']);
                        }
                    ?>

                    <label for="opis__input">Number telefonu</label>
                    <input type="text" name="numer_tel" class="input">
                    <?php //WYŚWIETLENIE BŁĘDU
                        if(isset($_SESSION['e_nr_tel'])){
                            echo '<span class="RegEx-check" style="color:white;">'.$_SESSION['e_nr_tel'].'</span><br><br>';
                            unset($_SESSION['e_nr_tel']);
                        }
                    ?>
                    <br><br>
                    <input type="submit" value="Wyślij">
                </div>
            </div>
        </form>

    </section>
</body>
</html>