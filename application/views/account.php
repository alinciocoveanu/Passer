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

    if(isset($_POST['del_id'])) {
        $itemId = $_POST['del_id'];
        $itemsController->deleteItem($itemId);
    }

    if(isset($_POST['edit_id'])) {
        $itemId = $_POST['edit_id'];
        $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
        $itemsController->editItem($itemId, $item);
    }

    if(isset($_POST['add_id'])){
        $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
        $itemsController->addItem($item);
    }
    
    // if(isset($_POST['title']) || isset($_POST['username']) || isset($_POST['password']) || isset($_POST['url']) || isset($_POST['comment']) || isset($_POST['maxTime'])) {
    //     $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
    //     $itemsController->addItem($item);
    // }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-16">
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
                <label>Order by</label>
                <form method="GET" action="account.php">
                    <select name="orderType" title="Order by">
                        <option value="titleAZ">Title (A-Z)</option>
                        <option value="titleZA">Title (Z-A)</option>
                        <option value="domain">Domain</option>
                        <option value="strength">Password Strength</option>
                        <option value="freq">Frequency</option>
                    </select>
                    <input type="submit" value="SORT">
                </form>
            </div>

            <div class="rButton">
                <button onclick="document.getElementById('addBox').style.display='block'" id="addButton" type="submit">Add</button>
                <div id="addBox" class="popUpBox">
                    <form class="popUpBoxContent animate" method="post" action="account.php">
                        <div style="padding: 20px">
                            <input type="hidden" name="add_id" value="add">

                            <input type="text" placeholder="Enter Title" name="title" required>

                            <input type="text" placeholder="Enter Webpage URL" name="url" required>

                            <input type="text" placeholder="Enter Username" name="username" required>

                            <input type="password" placeholder="Enter Password" name="password" id="password" required>
                            
                            <button type="button" onclick="showPassword('add')" class="showPassword">Show Password</button>

                            <button type="button" onclick="generatePassword('add')" class="generatePassword">Generate Password</button>


                            <input type="text" placeholder="Comment / Description" name="comment">

                            <label>Availability:</label><input type="date" min="<?php echo date('dd-mm-YY'); ?>" name="maxTime" placeholder="Availability">

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
                        <?php
                        if(isset($_GET['orderType'])) {
                            $items = $itemsController->getAllItems($_GET['orderType']);
                        } else {
                            $items = $itemsController->getAllItems("default");
                        }
                        if(!$items) {
                            // error handling
                        } else 
                            while ($row = mysqli_fetch_assoc($items)): ?>
                            <li>
                                <span class="title"><?php echo $row['title']; ?></span>
                                <span class="username"><?php echo $row['username']; ?></span>
                                <span class="edit">
                                    <a href="#"><img src="/Passer/public/images/edit.png" alt="submit" onclick="document.getElementById('editBox<?php echo $row['item_id'] ?>').style.display='block'" width="30" height="30"></a>
                                </span>
                                <form method="post" action="account.php">
                                    <span class="delete">
                                        <input type="hidden" name="del_id" value="<?php echo $row['item_id']; ?>">
                                        <input type="image" src="/Passer/public/images/delete.png" alt="submit" width="40" height="30">
                                    </span>
                                </form>
                            </li>
                            <div id="editBox<?php echo $row['item_id'] ?>" class="popUpBox">
                                <form class="popUpBoxContent animate" method="post" action="account.php">
                                    <div style="padding: 20px">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['item_id']; ?>">

                                        <input type="text" placeholder="Enter Title" name="title" value = "<?php echo $row['title'] ?>" required>

                                        <input type="text" placeholder="Enter Webpage URL" name="url" value = "<?php echo $row['url'] ?>" required>

                                        <input type="text" placeholder="Enter Username" name="username" value = "<?php echo $row['username'] ?>" required>

                                        <input type="password" placeholder="Enter Password" name="password" id="passwordEd<?php echo $row['item_id'] ?>" value = "<?php echo $row['password'] ?>" required>

                                        <button type="button" onclick="showPassword(<?php echo $row['item_id'] ?>)" class="showPassword">Show Password</button>

                                        <button type="button" onclick="generatePassword(<?php echo $row['item_id'] ?>)" class="generatePassword">Generate Password</button>

                                        <input type="text" placeholder="Comment / Description" name="comment" value = "<?php echo $row['comment'] ?>">

                                        <label>Availability:</label><input type="date" min="<?php echo date('dd-mm-YY'); ?>" name="maxTime" placeholder="Availability" value = "<?php echo $row['max_time'] ?>">

                                        <button type="submit">Edit</button>
                                    </div>

                                    <div class="boxLower">
                                        <button type="button" onclick="document.getElementById('editBox<?php echo $row['item_id'] ?>').style.display='none'" class="cancelButton">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        <?php
                            endwhile; ?>
                    </ul>
            </div>
        </div>
        
        <script>
            function showPassword(id) {
                var x = '';
                switch(id) {
                    case 'add': 
                        x = document.getElementById("password");
                        break;
                    default:
                        x = document.getElementById("passwordEd" + id);
                }

                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

            function generatePassword(id) {
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
                        if (xmlhttp.status == 200) {
                            var x;
                            switch(id) {
                                case 'add': 
                                    x = document.getElementById("password");
                                    break;
                                default:
                                    x = document.getElementById("passwordEd" + id);
                            }
                            x.value = xmlhttp.responseText;
                        }
                        else if (xmlhttp.status == 400) {
                            alert('There was an error 400');
                        }
                        else {
                            alert('something else other than 200 was returned' + xmlhttp.responseText);
                        }
                    }
                };
                
                xmlhttp.open("GET", "http://localhost:1234/Passer/public/actionPage.php?op=password", true);
                xmlhttp.send();
            }
        </script>
    </body>
</html>