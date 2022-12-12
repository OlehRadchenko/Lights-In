<?php
session_start();
if(isset($_SESSION['zalogowany'])){
  header('Location: index_zalogowany.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MainStyle.css">
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
            <!-- Przyciski -->
            <div id="HeaderNav-buttons">
                <div id="HeaderNav-login">
                    <button id="Login-loginBtn">Zaloguj się
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
                                    <input type="submit" value="Zaloguj się" id="DropLogin-loginBtn">
                                </div>                             
                            </div>    
                        </form>                
                    </div>
                </div>
                <div id="HeaderNav-register">
                    <button id="Register-registerBtn">
                        <a href="SiteRegister.php">Zarejstruj się</a>
                    </button> 
                </div>
            </div>    
    </header>
    <section>
      <div id="Section-top">
        <div id="Section-delivery">
          <p>Sprawdź gdzie jesteśmy</p>           
          <!--<div id="Section-deliveryInputs">
              <i class="fa fa-map-marker icon-marker" aria-hidden="true"></i>
              <input type="text" id="DeliveryInputs-adressInput"  placeholder="Adres zamieszkania">
              <i class="fa fa-calendar icon-calendar" aria-hidden="true"></i>
              <input type="text" id="DeliveryInputs-dateInput"  placeholder="Kiedy planujesz wizytę?">
                    
              <button id="DeliveryInputs-orderButton">Zamów</button>*/
          </div>-->
            <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1s-RfKuQiU0Qz8HSCBHLQGhA2iCzxWRc&ehbc=2E312F" width="870" height="500"></iframe>
        </div>
      </div>
    </section>
    
    <main>
        <section>
            <div id="MainSection-container">  
                <div class="Container-">
                    <div class="Slider-box"> 
                      <img
                        src="SiteAddons/prac__1.jpg"
                        alt=""
                        class="strona lewa"
                      />
                      <p class="strona prawa">
                        Michał Jóźwiak <br><br>
                          Stanowisko: Elektryk <br><br>
                          "Są dwie drogi, aby przeżyć życie. Jedna to żyć tak, jakby nic nie było cudem. Druga to żyć tak, jakby cudem było wszystko."
                          <br><br>
                          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos enim odit tempore voluptas, eveniet reiciendis omnis! Suscipit accusantium autem vero? Expedita, blanditiis asperiores! Veniam quos veritatis doloribus. Est, neque incidunt?
                      </p>
                    </div>
                    <div class="Slider-box">
                      <p class="strona lewa">
                        Justyn Bielawski <br><br>
                          Stanowisko: Elektryk <br><br>
                          "Są dwie drogi, aby przeżyć życie. Jedna to żyć tak, jakby nic nie było cudem. Druga to żyć tak, jakby cudem było wszystko."
                          <br><br>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit magni repellendus sapiente voluptas minus ipsam, nihil suscipit enim ex eos accusantium tempora vel pariatur inventore consequatur atque neque dolorum ea?

                      </p>
                      <img
                      src="SiteAddons/prac__2.jpg"
                        alt=""
                        class="strona prawa"
                      />
                    </div>
                    <div class="Slider-box">
                      <img
                      src="SiteAddons/prac__3.jpg"
                        alt=""
                        class="strona lewa"
                      />
                      <p class="strona prawa">
                        Szymon Gawroński <br><br>
                          Stanowisko: Elektryk <br><br>
                          "Są dwie drogi, aby przeżyć życie. Jedna to żyć tak, jakby nic nie było cudem. Druga to żyć tak, jakby cudem było wszystko."
                          <br><br>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt libero nisi fuga, eligendi alias rem, neque minima ut reprehenderit ab debitis velit magni eos optio aperiam ducimus ipsa? Deserunt, sunt.
                      </p>
                    </div>
                    <div class="Slider-box">
                      <p class="strona lewa">
                        Emil Matuszak <br><br>
                          Stanowisko: Elektryk <br><br>
                          "Są dwie drogi, aby przeżyć życie. Jedna to żyć tak, jakby nic nie było cudem. Druga to żyć tak, jakby cudem było wszystko."
                          <br><br>
                          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Soluta dolorem fugiat, sequi eveniet labore quo perspiciatis incidunt non blanditiis ipsum optio, asperiores atque quibusdam quae corrupti ipsa aliquam. Ad, voluptatem.
                      </p>
                      <img
                      src="SiteAddons/prac__4.jpg"
                        alt=""
                        class="strona prawa"
                      />
                    </div>
                    <div class="Slider-box">
                      <img
                      src="SiteAddons/prac__5.jpg"
                        alt=""
                        class="strona lewa"
                      />
                      <p class="strona prawa">
                        Paweł Kalisz<br><br>
                          Stanowisko: Elektryk <br><br>
                          "Są dwie drogi, aby przeżyć życie. Jedna to żyć tak, jakby nic nie było cudem. Druga to żyć tak, jakby cudem było wszystko."
                          <br><br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab sint repellat cupiditate quisquam itaque, fugiat quod aut numquam? Sint sed numquam dicta possimus cupiditate consequatur ea magnam beatae vero? Sapiente.
                      </p>
                    </div>
                </div>          
            </div>
        </section>
    </main>
</body>
</html>