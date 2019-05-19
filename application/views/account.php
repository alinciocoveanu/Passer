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
    $userId = $usersController->getUserId($user->getUsername());
    $itemsController = new ItemsController($userId);

    // https://github.com/elboletaire/password-strength-meter
    // https://www.siphor.com/add-password-strength-meter-html5/
    // https://stackoverflow.com/questions/948172/password-strength-meter
    // https://css-tricks.com/password-strength-meter/
    // https://www.solodev.com/blog/web-design/creating-a-password-strength-indicator.stml

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
                            <button class="dropdown-button">
                                Export as  <!-- TODO -->
                            </button>
                            <!-- <div class="dropdownContent">
                                <a href="#">XML</a>
                                <a href="#">JSON</a>
                                <a href="#">CSV</a>
                            </div> -->
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
                <form method="GET" action="/Passer/public/actionPage.php">
                    <select name="orderType" title="Order by">
                        <option value="titleAZ">Title (A-Z)</option>
                        <option value="titleZA">Title (Z-A)</option>
                        <option value="domain">Domain</option>
                        <option value="strength">Password Strength</option>
                        <option value="freq">Frequency</option>
                    </select>
                    <button name="op" type="submit" value="list">SORT</button>
                </form>
            </div>

            <div class="rButton">
                <button onclick="document.getElementById('addBox').style.display='block'" id="addButton" type="submit">Add</button>
                <div id="addBox" class="popUpBox">
                    <form class="popUpBoxContent animate" method="post" action="/Passer/public/actionPage.php">
                        <div style="padding: 20px">
                            <input type="hidden" name="add_uid" value="<?php echo $userId; ?>">

                            <input type="text" placeholder="Enter Title" name="title" required>

                            <input type="text" placeholder="Enter Webpage URL" name="url" required>

                            <input type="text" placeholder="Enter Username" name="username" required>

                            <input type="password" placeholder="Enter Password" name="password" id="password" required>
                            
                            <button type="button" onclick="showPassword('add')" class="showPassword">Show Password</button>

                            <button type="button" onclick="generatePassword('add')" class="generatePassword">Generate Password</button>


                            <input type="text" placeholder="Comment / Description" name="comment">

                            <label>Availability:</label><input type="date" min="<?php echo date('dd-mm-YY'); ?>" name="maxTime" placeholder="Availability">

                            <button name="op" value="add" type="submit">Add</button>
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
                            if(isset($_GET['orderType'])){
                                $items = $itemsController->getAllItems($_GET['orderType']);
                            } else {
                                $items = $itemsController->getAllItems('default');
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
                                    <form method="post" action="/Passer/public/actionPage.php?op=delete">
                                        <span class="delete">
                                            <input type="hidden" name="del_id" value="<?php echo $row['item_id']; ?>">
                                            <input type="hidden" name="del_uid" value="<?php echo $userId; ?>">
                                            <input type="image" src="/Passer/public/images/delete.png" alt="submit" width="40" height="30">
                                        </span>
                                    </form>
                                </li>
                                <div id="editBox<?php echo $row['item_id'] ?>" class="popUpBox">
                                    <form class="popUpBoxContent animate" method="post" action="/Passer/public/actionPage.php">
                                        <div style="padding: 20px">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['item_id']; ?>">

                                            <input type="hidden" name="edit_uid" value="<?php echo $userId; ?>">

                                            <input type="text" placeholder="Enter Title" name="title" value = "<?php echo $row['title'] ?>" required>

                                            <input type="text" placeholder="Enter Webpage URL" name="url" value = "<?php echo $row['url'] ?>" required>

                                            <input type="text" placeholder="Enter Username" name="username" value = "<?php echo $row['username'] ?>" required>

                                            <input type="password" placeholder="Enter Password" name="password" id="passwordEd<?php echo $row['item_id'] ?>" value = "<?php echo $row['password'] ?>" required>

                                            <button type="button" onclick="showPassword(<?php echo $row['item_id'] ?>)" class="showPassword">Show Password</button>

                                            <button type="button" onclick="generatePassword(<?php echo $row['item_id'] ?>)" class="generatePassword">Generate Password</button>

                                            <input type="text" placeholder="Comment / Description" name="comment" value = "<?php echo $row['comment'] ?>">

                                            <label>Availability:</label><input type="date" min="<?php echo date('dd-mm-YY'); ?>" name="maxTime" placeholder="Availability" value = "<?php echo $row['max_time'] ?>">

                                            <button name="op" value="edit" type="submit">Edit</button>
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
                    if (xmlhttp.readyState == XMLHttpRequest.DONE) { //handle response
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
                
                xmlhttp.open("GET", "http://localhost/Passer/public/actionPage.php?op=password", true); //send a request to api
                xmlhttp.send();
            }
        </script>
    </body>
</html>