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
            <nav>
                <ul>
                    <li class="current"><a href="index.php">About</a></li>
                    <li><a href="index.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="formular">
        <div class="formular">
            <h3>Create an account</h3>
            <form class="createFormular"
                onsubmit="checkPass();" action="/Passer/public/actionPage.php" method="post">
                <?php if(@$_GET['err'] == 1) { ?>
                <p>User already exists. Please try again.</p>
                <?php } ?>
                E-mail<br>
                <input type="text" name="email" required><br>
                Username<br>
                <input type="text" name="username" required><br>
                Password<br>
                <input type="password" id="password" name="password" required><br>
                Confirm password<br>
                <input type="password" id="confirm_password" required><br>
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
    </script>

    <footer>
        <p>Passer - Password Manager &copy; 2019</p>
    </footer>
</body>
</html>