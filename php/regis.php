<?php

if (isset($_POST['submit'])) {
    include_once("db_connect.php");
    $rgName = addslashes($_POST['name']);
    $rgEmail = $_POST['email'];
    $rgPass = $_POST['passwprd'];
    $rgPhone = $_POST['phone'];
    $rgAdd = $_POST['address'];
    $sqlinsertproduct = "INSERT INTO `login_wmt`(`name`, `email`, `pass`, `pno`, `addr`) VALUES 
    ('$rgName','$rgEmail','$rgPass','$rgPhone','$rgAdd')";
    try {
        $conn->exec($sqlinsertproduct);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $last_id = $conn->lastInsertId();
            uploadImage($last_id);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('index.php')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    }
}

function uploadImage($filename)
{
    $target_dir = "../resources/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="../js/script.js"></script>

    <title>My Tutor</title>
</head>
<style>
body {
    background-image: url("1.png");
}

img.inset {
    border-style: inset;
}

.button {
    background-color: #c2fbd7;
    border-radius: 50px;
    border-width: 0;
    box-shadow: rgba(25, 25, 25, .04) 0 0 1px 0, rgba(0, 0, 0, .1) 0 3px 4px 0;
    color: green;
    cursor: pointer;
    display: inline-block;
    font-family: Arial, sans-serif;
    font-size: 1em;
    height: 40px;
    padding: 0 25px;
    transition: all 200ms;
}

.button:hover {
    background-color: #afe6c3;
    transform: scale(1.05);

}
</style>

<body>
    <header class="w3-header w3-center">
        <h2 style="font-weight:bold ">
            My Tutor
        </h2>
    </header>
    <div style="display:flex; justify-content: center">
        <div class="w3-white w3-container .form-container-reg w3-card w3-padding"
            style="max-width:1200px;border-radius: 20px;">
            <h3 class="w3-center">
                <b>User Registration</b>
            </h3>

            <form class="w3-container w3-padding formco" action="regis.php" method="post" enctype="multipart/form-data">
                <p>
                <div class="w3-container w3-padding w3-center">
                    <img class="w3-image inset w3-round w3-margin" src="../resources/profile.jpg"
                        style="height:100%;width:400px"><br>
                    <input type="file" name="fileToUpload" onchange="previewFile()" id="fileToUpload" required>
                </div>
                </p>
                <p>
                    <label><b>Name</b></label>
                    <input class="w3-input w3-round w3-border" type="name" name="name" id="idname"
                        placeholder="Your name" required>
                </p>
                <p>
                    <label><b>Email</b></label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail"
                        placeholder="Your email" required>
                </p>
                <p>
                    <label><b>Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="idpassword"
                        placeholder="Your password" required>
                </p>
                <p>
                    <label><b>Home Address</b></label>
                    <textarea class="w3-input w3-round w3-border" type="address" name="address" id="idaddress" rows="4"
                        width="100%" placeholder="Your home address" required></textarea>
                </p>
                <p>
                    <label><b>Phone Number</b></label>
                    <input class="w3-input w3-round w3-border" type="number" name="phone" id="idphone"
                        placeholder="Your phone number" required>
                </p>
                <p>
                    <input class="button w3-center" type="submit" name="submit" value="Submit">
                </p>

            </form>
            <form class="w3-container w3-padding" name="register form" action="regis.php" method="post"
                onsubmit="return confirmDialog()" enctype="multipart/form-data">

            </form>
        </div>

    </div>

    <footer class="w3-footer w3-center">
        <p>
            Copyright © 2019 MyTutorWong
        </p>


    </footer>
</body>

</html>