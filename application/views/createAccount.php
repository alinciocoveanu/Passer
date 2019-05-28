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

    <title>Passer | Create Account</title>
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

    <section id="formular">
        <div class="formular">
            <h3>Create an account</h3>
            <form class="createFormular"
                onsubmit="checkPass();" action="/Passer/public/loginControl.php" method="post">
                <?php if(@$_GET['err'] == 1) { ?>
                <p>User already exists. Please try again.</p>
                <?php } ?>
                E-mail<br>
                <input type="email" name="email" required><br>
                Username<br>
                <input type="text" name="username" pattern="[^\s]{6,}" title="Username must not contain spaces and must have a minimum length of 6" required><br>
                Password<br>
                <input type="password" id="password" name="password" pattern=".{8,}" title="Minimum 8 characters" required><br>
                <div class="eyeCreate">
                    <img src="/Passer/public/images/eye.png" alt="eye Back" width="30">
                    <img src="/Passer/public/images/eye-slash.png" onmouseover="showPassword();" onmouseout="hidePassword();" class="img-top" width="30" alt="eye Front">
                </div><br>
                Confirm password<br>
                <input type="password" id="confirm_password" required><br>
                <div class="eyeCreate">
                    <img src="/Passer/public/images/eye.png" alt="eye Back" width="30">
                    <img src="/Passer/public/images/eye-slash.png" onmouseover="showPassword('confirm');" onmouseout="hidePassword('confirm');" class="img-top" width="30" alt="eye Front">
                </div><br>
                <input type="checkbox" required>Do you agree with our terms and services?<br>
                <span id='message'></span><br>
                <button type="submit" name="op" value="register" style="width: 45%">Submit</button>
            </form>
        </div>
    </section>

    <script>
        function checkPass() {
            if (document.getElementById('password').value != document.getElementById('confirm_password').value) {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Passwords must match';
                event.preventDefault();
                return false;
            } else {
                document.getElementById('message').innerHTML = '';
                return true;
            }
        }
        function showPassword(id) {
            var x = '';
            switch(id) {
                case 'confirm': 
                    x = document.getElementById("confirm_password");
                    break;
                default:
                    x = document.getElementById("password");
                    break;
            }
            x.type = "text";
        }

        function hidePassword(id) {
            var x = '';
            switch(id) {
                case 'confirm': 
                    x = document.getElementById("confirm_password");
                    break;
                default:
                    x = document.getElementById("password");
                    break;
            }
            x.type = "password";
        }
    </script>

    <footer>
        <p>Passer - Password Manager &copy; 2019</p>
    </footer>
</body>
</html>