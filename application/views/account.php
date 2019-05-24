<?php
    
    define('DS6', DIRECTORY_SEPARATOR);
    define('ROOT6', dirname(dirname(__FILE__)));
    
    require_once(ROOT6 . DS6 . 'controllers' . DS6 . 'UsersController.php');
    require_once(ROOT6 . DS6 . 'models' . DS6 . 'UserModel.php');
    session_start();
    
    if((!isset($_SESSION['user']))){
        header("Location:/Passer/application/views/index.php");
        exit;
    } else
        $user = $_SESSION['user'];

    $uid = $user->getUid();
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
                            <?php echo $user->getUsername(); ?>
                        </button>
                        <div class="dropdownContent">
                            <button class="dropdown-button" onclick="document.getElementById('expBox').style.display='block'">Export</button>
                            <a href="/Passer/public/loginControl.php?op=logout">Log out</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <div id="expBox" class="exportBox">
                <span onclick="document.getElementById('expBox').style.display='none'" class="close">&times;</span>
                <form class="exportBoxContent animate" action="/Passer/public/actionPage.php" method="post">
                    <div id="exportTop">
                        <p>Export as: </p><br>
                    </div>
                    <div div="exportLower">
                        <input type="hidden" name="uid" value="<?php echo $uid; ?>"></input>
                        <input type="radio" name="format" value="xml" required>XML</input><br>
                        <input type="radio" name="format" value="json" required>JSON</input><br>
                        <input type="radio" name="format" value="csv" required>CSV</input><br>
                        <button type="submit" name="op" value="export" onclick="document.getElementById('expBox').style.display='none'">Export</button> 
                    </div>
                </form>
            </div>
        </div>

        <div id="rightBox">
            <div class="custom-select">
                <label>Order by:</label>
                <form method="post" action="/Passer/public/actionPage.php">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>"></input>
                    <select name="orderType" title="Order by">
                        <option value="titleAZ">Title (A-Z)</option>
                        <option value="titleZA">Title (Z-A)</option>
                        <option value="domain">Domain</option>
                        <option value="strength">Password Strength</option>
                        <option value="freq">Frequency</option>
                    </select>
                    <button name="op" type="submit" value="list" id="sortButton">SORT</button>
                </form>
            </div>

            <div class="rButton">
                <button onclick="document.getElementById('addBox').style.display='block'" id="addButton" type="submit">Add</button>
                <div id="addBox" class="popUpBox">
                    <form class="popUpBoxContent animate" method="post" action="/Passer/public/actionPage.php" id="addForm">
                        <div style="padding: 20px">
                            <input type="hidden" name="add_uid" value="<?php echo $uid; ?>">

                            <input type="text" placeholder="Enter Title" name="title" required>

                            <input type="text" placeholder="Enter Webpage URL" name="url" required>

                            <input type="text" placeholder="Enter Username" name="username" required>

                            <input type="text" placeholder="Comment / Description" name="comment">

                            <input type="password" placeholder="Enter Password" name="password" id="password" required>

                            <div class="eye">
                                <img src="/Passer/public/images/eye.png" alt="eye Back" width="30">
                                <img src="/Passer/public/images/eye-slash.png" onmouseover="showPassword('add');" onmouseout="hidePassword('add');" class="img-top" width="30" alt="eye Front">
                            </div>
                            <div class="lengthPass">
                                <button type="button" onclick="generatePassword('add')" class="generatePassword">Generate Password</button>
                                <input  type="range" id="inputLengthVal" name="length" min="8" max="100" value="16" oninput="outputLengthVal.value = inputLengthVal.value"></input>
                                <output id="outputLengthVal">16</output>
                            </div>

                            <label>Availability:</label><input type="date" name="maxTime" placeholder="Availability" id="addDate">

                            <button name="op" value="add" type="submit">Add</button>
                        </div>

                        <div class="boxLower">
                            <button type="button" onclick="closePopUp('add')" class="cancelButton">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="passItems">
                    <ul>
                        <?php
                            if(isset($_SESSION['items'])) {
                                $items = $_SESSION['items'];
                                if($items != null) {
                                    foreach($items as $row) {
                                        $id = $row[0];
                                        $available = true;
                                        if(time() - strtotime($row[7]) >= 0 && $row[7] != '0000-00-00') {
                                            $available = false;
                                        }
                        ?>
                                    <li>
                                    <span class="title" <?php if(!$available) {?> style="color: red" <?php } ?> ><?php echo $row[2]; ?></span>
                                        <span class="username" <?php if(!$available) {?> style="color: red" <?php } ?> ><?php echo $row[3]; ?></span>
                                        <span class="copy">
                                            <a href="#"><img src="/Passer/public/images/copy-512.png" width="40" height="30" onclick="copyPassword('<?php echo $row[4] ?>')"></a>
                                        </span>
                                        <span class="edit">
                                            <a href="#"><img src="/Passer/public/images/edit.png" alt="submit" onclick="document.getElementById('editBox<?php echo $id ?>').style.display='block'" width="30" height="30"></a>
                                        </span>
                                        <form method="post" action="/Passer/public/actionPage.php?op=delete">
                                            <span class="delete">
                                                <input type="hidden" name="del_id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="del_uid" value="<?php echo $uid; ?>">
                                                <input type="image" src="/Passer/public/images/delete.png" alt="submit" width="40" height="30">
                                            </span>
                                        </form>
                                    </li>
                                    <div id="editBox<?php echo $id ?>" class="popUpBox">
                                        <form class="popUpBoxContent animate" method="post" action="/Passer/public/actionPage.php" id="editForm<?php echo $id ?>">
                                            <div style="padding: 20px">
                                                <input type="hidden" name="edit_id" value="<?php echo $id; ?>">

                                                <input type="hidden" name="edit_uid" value="<?php echo $uid; ?>">

                                                <?php if(!$available) {?> <p style="color: red">Please change your password!</p> <?php } ?>

                                                <input type="text" placeholder="Enter Title" name="title" value = "<?php echo $row[2] ?>" required>

                                                <input type="text" placeholder="Enter Webpage URL" name="url" value = "<?php echo $row[5] ?>" required>

                                                <input type="text" placeholder="Enter Username" name="username" value = "<?php echo $row[3] ?>" required>
                                                
                                                <input type="text" placeholder="Comment / Description" name="comment" value = "<?php echo $row[6] ?>">
                                                <label> 
                                                <input type="password" placeholder="Enter Password" name="password" id="passwordEd<?php echo $id ?>" value = "<?php echo $row[4] ?>" required>
                                                <div class="eye">
                                                    <img src="/Passer/public/images/eye.png" alt="eye Back" width="30">
                                                    <img src="/Passer/public/images/eye-slash.png" onmouseover="showPassword(<?php echo $id ?>);" onmouseout="hidePassword(<?php echo $id ?>);" class="img-top" width="30" alt="eye Front">
                                                </div>
                                                <div class="lengthPass">
                                                    <button type="button" onclick="generatePassword(<?php echo $id ?>)" class="generatePassword">Generate Password</button>
                                                    <input  type="range" id="inputLengthVal<?php echo $id ?>" name="length" min="8" max="100" value="16" oninput="outputLengthVal<?php echo $id ?>.value = inputLengthVal<?php echo $id ?>.value"></input>
                                                    <output id="outputLengthVal<?php echo $id ?>">16</output>
                                                </div>
                                                
                                                <label>Availability:</label><input type="date" name="maxTime" placeholder="Availability" value = "<?php echo $row[7] ?>" id="editDate<?php echo $id ?>">
                                                <script>
                                                    var today = new Date();
                                                    var dd = today.getDate() + 1;
                                                    var mm = today.getMonth() + 1;
                                                    var yyyy = today.getFullYear();
                                                    if(dd < 10) dd = '0' + dd;
                                                    if(mm < 10) mm = '0' + mm;

                                                    today = yyyy + '-' + mm + '-' + dd;
                                                    document.getElementById("editDate<?php echo $id ?>").setAttribute("min", today);
                                                </script>
                                                <button name="op" value="edit" type="submit">Edit</button>
                                            </div>

                                            <div class="boxLower">
                                                <button type="button" onclick="closePopUp(<?php echo $id ?>, '<?php echo $row[4] ?>')" class="cancelButton">Cancel</button>
                                            </div>                             
                                        </form>
                                    </div>
                            <?php
                                        }
                                }
                            } ?>
                    </ul>
            </div>
        </div>
        
        <script>
            var today = new Date();
            var dd = today.getDate() + 1;
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if(dd < 10) dd = '0' + dd;
            if(mm < 10) mm = '0' + mm;

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("addDate").setAttribute("min", today);

            function closePopUp(id, password) {
                var x = '', y = '';
                switch(id) {
                    case 'add': 
                        x = document.getElementById("addBox");
                        document.getElementById("addForm").reset();
                        break;
                    default:
                        x = document.getElementById("editBox" + id);
                        document.getElementById("editForm" + id).reset();
                        break;
                }
                x.style.display = 'none';
            }

            function copyPassword(password) {
                    const elem = document.createElement('textarea');
                    elem.value = password;
                    document.body.appendChild(elem);
                    elem.select();
                    document.execCommand('copy');
                    document.body.removeChild(elem);
            }

            function showPassword(id) {
                var x = '';
                switch(id) {
                    case 'add': 
                        x = document.getElementById("password");
                        break;
                    default:
                        x = document.getElementById("passwordEd" + id);
                        break;
                }
                x.type = "text";
            }

            function hidePassword(id) {
                var x = '';
                switch(id) {
                    case 'add': 
                        x = document.getElementById("password");
                        break;
                    default:
                        x = document.getElementById("passwordEd" + id);
                        break;
                }
                x.type = "password";
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
                                    break;
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
                var length = 0;
                switch(id) {
                    case 'add': 
                        length = document.getElementById("inputLengthVal").value;
                        break;
                    default:
                        length = document.getElementById("inputLengthVal" + id).value;
                        break;
                }
                
                //!schimba aici daca nu merge generate!
                xmlhttp.open("GET", "http://localhost:1234/Passer/public/actionPage.php?op=password&length=" + length, true);
                xmlhttp.send();
            }
        </script>
        <?php
            if(isset($_GET['addErr'])) {
                $message = "Failed to add password.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            if(isset($_GET['editErr'])) {
                $message = "Failed to edit item.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            if(isset($_GET['delErr'])) {
                $message = "Failed to delete item.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            if(isset($_GET['listErr'])) {
                $message = "Failed to list items.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

            if(isset($_GET['expErr'])) {
                $message = "Failed to export.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        ?>
    </body>
</html>