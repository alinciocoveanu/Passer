<?php
    
    define('DS6', DIRECTORY_SEPARATOR);
    define('ROOT6', dirname(dirname(__FILE__)));
    
    require_once(ROOT6 . DS6 . 'controllers' . DS6 . 'UsersController.php');
    require_once(ROOT6 . DS6 . 'controllers' . DS6 . 'ItemsController.php');
    require_once(ROOT6 . DS6 . 'models' . DS6 . 'UserModel.php');
    session_start();

    
    if(!isset($_SESSION['user'])){
        header("Location:/Passer/application/views/index.php");
    } else {
        $user = $_SESSION['user'];
    }

    $usersController = new UsersController();
    $itemsController = new ItemsController($usersController->getUserId($user->getUsername()));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>Passer | My Account</title>
        <link rel="stylesheet" href="/Passer/public/css/style.css">
    </head>
    <body>
        <header style="min-height: 100px">
            <div class="container" id="enervant">
                <div id="branding">
                    <a class="logo">
                        <img src="/Passer/public/images/logo_transparent.png" alt="logo_transparent">
                    </a>
                </div>

            </div>
            <div id="drop-down">
                <nav>
                    <div class="dropdown">
                        <button class="dropdown-button"> 
                            <?php print $user->getUsername(); ?>
                        </button>
                        <div class="dropdownContent">
                            <a href="#">Account settings</a>
                            <a href="/Passer/public/actionPage.php?op=logout">Log out</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- <div id="leftMenu">
            <button class="leftMenuButton">Web Pages</button>
            <button class="leftMenuButton">Online banking</button>
            <button class="leftMenuButton">Emails</button>
            <button class="leftMenuButton">Wi-Fi networks</button>
        </div> -->

        <div id="rightBox">
            <div class="custom-select">
                <label>Group by</label>
                <select title="Order by">
                    <option value="titleAZ">Title (A-Z)</option>
                    <option value="titleZA">Title (Z-A)</option>
                    <option value="domain">Domain</option>
                    <option value="strength">Password Strength</option>
                    <option value="freq">Frequency</option>
                </select>
            </div>

            <div class="rButton">
                <button onclick="document.getElementById('addBox').style.display='block'" id="addButton" type="submit">Add</button>
                <div id="addBox" class="popUpBox">
                    <form class="popUpBoxContent animate" method="post">
                        <div style="padding: 20px">
                            <input type="text" placeholder="Enter Webpage URL" required>

                            <input type="text" placeholder="Enter Username" required>

                            <input type="password" placeholder="Enter Password" required>

                            <button type="submit">Add</button>
                        </div>

                        <div class="boxLower">
                            <button type="button" onclick="document.getElementById('addBox').style.display='none'" class="cancelButton">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="passItems">
                    <ul>
                        <?php $items = $itemsController->getAllItems();
                        if(!$items) {
                            // error handling
                        } else 
                            while ($row = mysqli_fetch_assoc($items)): ?>
                            <li>
                                <span class="title"><?php echo $row['title']; ?></span>
                                <span class="username"><?php echo $row['username']; ?></span>
                                <span class="edit"><img src="/Passer/public/images/edit.png" alt="edit_icon"></span>
                                <span class="delete"><img src="/Passer/public/images/delete.png" alt="delete_icon"></span>
                            </li>
                        <?php
                            endwhile; ?>
                    </ul>
            </div>
        </div>
    </body>
</html>