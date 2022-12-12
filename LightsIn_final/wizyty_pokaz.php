<?php
session_start();

if(!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIGHTS IN | Wszystkie wizyty użytkownika</title>
</head>
<body>
    Daty na które masz zarezerwowane wizyty:<br>
    <?php
    $id = $_SESSION['id'];
    require_once 'baza.php';
    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if($polaczenie->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        }else{
            $zapytanie = "SELECT * FROM wizyty WHERE ID_uzytkownika='$id'";
            $rezultat=$polaczenie->query($zapytanie);

            $ile_rekordow = $rezultat->num_rows;
            if($ile_rekordow>0){
                while ($wiersz=$rezultat->FETCH_ASSOC()) {
                    $id_el = $wiersz["ID_elektryka"];
                    $zapytanie2 = "SELECT * FROM pracownicy WHERE ID_pracownika='$id_el'";
                    $rezultat2 = $polaczenie->query($zapytanie2);
                    $wiersz2=$rezultat2->FETCH_ASSOC();
                    echo "<br> Data twojej wizyty:".$wiersz["Data_wizyty"]."<br>Imie elektryka: ".$wiersz2["Imie"]."<br>Nazwisko elektryka: ".$wiersz2["Nazwisko"]."<br>";
                }
            }else{
                echo "Nie masz żadnych zarejestrowanych wizyt ;c";
            }

            $polaczenie->close();
        }
    }catch(Exception $e){
        echo '<div class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</div>';
        //echo "<br>Informacja developerska: ".$e;
    }
    ?>
    <br>
    <a href="index.php">Powrót do strony głównej</a>
</body>
</html>