<?php
    session_start();
    if(isset($_SESSION['user']))
        header("Location:account.php")
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>Passer | Welcome</title>
        <link rel="stylesheet" href="/Passer/public/css/style.css">
    </head>

    <body>
        <header>
            <div class="container">
                <div id="branding">
                    <a href="index.php">
                        <img src="/Passer/public/images/logo_transparent.png" alt="logo transparent">
                    </a>
                </div>
            </div>
        </header>

        <section id="showcase">
            <div class="container">
                <h1>Passer - Password Manager</h1>
            </div>
        </section>

        <section id="login">
            <div id="logBut">
                <!-- Log In button - opens the pop up box-->
                <button onclick="document.getElementById('logInBox').style.display='block'" style="width:auto;">Log In</button>
            </div>
            <div id="logInBox" class="popUpBox">
                <form class="popUpBoxContent animate" method="post" action="/Passer/public/loginControl.php">
                    <div style="padding: 20px">
                        <?php if(@$_GET['err'] == 1) { ?>
                        <p>Login Incorrect. Please try again.</p>
                        <?php } ?>
                        <input type="text" placeholder="Enter Username" name="username" required>

                        <input id="password" type="password" placeholder="Enter Password" name="password" required>
                        <div class="eye">
                            <img src="/Passer/public/images/eye.png" alt="eye Back" width="30">
                            <img src="/Passer/public/images/eye-slash.png" onmouseover="showPassword();" onmouseout="hidePassword();" class="img-top" width="30" alt="eye Front">
                        </div>

                        <button type="submit" name="op" value="login">Log In</button>
                        <button type="button" onclick="location.href='createAccount.php';">Create an account</button>
                    </div>

                    <div class="boxLower">
                        <button type="button" onclick="document.getElementById('logInBox').style.display='none'" class="cancelButton">Cancel</button>
                    </div>
                </form>
            </div>
        </section>
        <script>
        function showPassword() {
            var x = document.getElementById("password");
            x.type = "text";
        }

        function hidePassword() {
            var x = document.getElementById("password");
            x.type = "password";
        }
        </script>

        <section id="boxes">
            <div class="container">
                <div class="box">
                    <img src="/Passer/public/images/safe-box-deposit-bank-storage-512.png" alt="logo_transparent">
                    <h3>Safe Storage</h3>
                    <p></p>
                </div>

                <div class="box">
                    <img src="/Passer/public/images/product_icon_passwordreset.png" alt="logo_transparent">
                    <h3>Generate strong passwords</h3>
                    <p></p>
                </div>

                <div class="box">
                    <img src="/Passer/public/images/digitalStorage.png" alt="logo_transparent">
                    <h3>Store digital records</h3>
                    <p></p>
                </div>

                <div class="box">
                    <img src="/Passer/public/images/share_PNG23.webp" alt="logo_transparent">
                    <h3>Share effortlessly</h3>
                    <p></p>
                </div>

            </div>
        </section>
        
        <script>
            const params = new URLSearchParams(window.location.search);
            const param = params.get('err');
            if(param == 1){
                var elem = document.getElementById('logInBox');
                elem.style.display = 'block';
            }
        </script>

        <footer>
            <p>Passer - Password Manager &copy; 2019</p>
        </footer>
    </body>
</html>
