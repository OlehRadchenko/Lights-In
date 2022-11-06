<?php //PRZEKIEROWANIE do profilu jeżeli użytkownik jest już zalogowany
    session_start();
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']){
        header('Location: profil.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="prot1.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/427/427735.png"
    type = "image/x-icon">
    <title>LIGHTS IN | USŁUGI ELEKTRYCZNE</title>
    <script defer src="Mainscript.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.1/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
    <header>
        <nav id="HeaderNav">
            <div id="HeaderNav-banner">
                <div id="HeaderNav-foldMenu">
                    <input type="checkbox" id="drop_menu">
                    <label id="burger" for="drop_menu">
                    <div></div>
                    <div></div>
                    <div></div>
                    </label> 
                    <ul id="menu">
                        <a href="#"><li>Home</li></a>
                        <a href="#"><li>Usługi</li></a>
                        <a href="#"><li>Zamówienia</li></a>
                        </ul>
                </div>
                <div id="HeaderNav-logo">           
                    <img id="Logo-img" src="addons/lightbulb-logo.png" alt="Logo">
                    <a href="#">Lights <br> In</a> 
                </div>
            </div>
            <!-- Przyciski -->
            <div id="HeaderNav-buttons">
                <div id="HeaderNav-login">
                    <button id="Login-loginBtn" onclick="Drop_login()">Zaloguj się
                        <iconify-icon id="Login-loginIcon" icon="bi:person-fill" width="30" height="30"></iconify-icon>
                    </button>
                    <!-- DropMenu -->
                    <div id="HeaderNav-dropLogin" class="HeaderNav-dropLogin">
                        <form action="zaloguj.php" method="POST">
                        <input type="text" class="DropLogin-loginInput" name="login" placeholder="Wpisz adres e-mail lub login"> 
                        <br><br>
                        <input type="password" class="DropLogin-loginInput" name="haslo" placeholder="Wpisz hasło">
                        <?php //WYŚWIETLENIE BŁĘDU
                        if(isset($_SESSION['blad'])){
                            echo $_SESSION['blad'];
                        }
                        ?>
                        <div id="DropLogin-after">
                            <div id="DropLogin-Password">
                                <a href="#">Nie pamiętasz hasła?</a>
                            </div>
                            <div id="DropLogin-login">
                                <input type="submit" id="DropLogin-loginBtn" value="Zaloguj się">
                            </div>                             
                        </div>   
                        </form>                 
                    </div>
                </div>
                <div id="HeaderNav-register">
                    <a href="rejestracja.php">
                        <button id="Register-registerBtn" >
                            Zarejstruj się
                        </button> 
                    </a>
                </div>
            </div>
        </nav>       
    </header>
    <section>
        <div id="SiteSection-top">
            <div id="SiteSection-delivery">
                <p>Oświetl swój dom jednym kliknięciem</p>           
                <div id="SiteSection-deliveryInput">
                    <i class="fa fa-map-marker icon-marker" aria-hidden="true"></i>
                    <input type="text" id="Delivery-adressInput"  placeholder="Adres dostawy żarówki">
                    <i class="fa fa-calendar icon-calendar" aria-hidden="true"></i>
                    <input type="text" id="Delivery-dateInput"  placeholder="Kiedy dostarczyć?">
                    
                    <button id="Delivery-orderButton">Zamów</button>
                </div>
            </div>
        </div>
    </section>
    
    <main>
        <section>
            <div id="SiteHeader-mainContent">               
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloribus cumque similique harum iusto ea omnis ex error a, nemo iure fuga aut culpa id ratione sed voluptatum labore quam quis.
                Sit repudiandae ipsam repellendus eaque debitis est quo voluptate omnis ex rem perspiciatis, pariatur praesentium, incidunt delectus, modi exercitationem quisquam at impedit voluptatum magnam! Eius odit perspiciatis sequi modi dolorum.
                Repellat porro sapiente eum sint incidunt nobis exercitationem doloremque, ipsum nulla modi accusantium quibusdam? Eos suscipit quis, vero voluptatem ab quo, dignissimos dolores aperiam nam, officiis possimus in quasi optio.
                Et cum possimus exercitationem porro aperiam soluta quam iusto inventore libero veniam, nesciunt repudiandae facilis excepturi dignissimos neque laudantium corrupti iure! Obcaecati iure autem earum eos officiis et esse blanditiis.
                At, quisquam ipsam, ea accusamus doloribus eos, nam totam facere assumenda veritatis minus dolore! Sequi, minus dolorem dolores excepturi dolorum, molestias suscipit facilis debitis ut et inventore saepe voluptatem corrupti.
            </div>
        </section>
    </main>   
</body>



</html>

