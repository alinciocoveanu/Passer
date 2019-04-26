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
            <form method="post" class="createFormular" action="account.php">
                First name<br>
                <input type="text" name="firstName" required><br>
                Last name<br>
                <input type="text" name="lastName" required><br>
                Username<br>
                <input type="text" name="username" required><br>
                Password<br>
                <input type="password" name="password" required><br>
                Confirm password<br>
                <input type="password" required><br>
                <input type="checkbox" required>Do you agree with our terms and services?<br>
                <button type="submit" name="op" value="register" style="width: 45%">Submit</button>
            </form>
        </div>
    </section>

    <footer>
        <p>Passer - Password Manager &copy; 2019</p>
    </footer>
</body>
</html>