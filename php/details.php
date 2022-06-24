<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
}else{
    $user_email = "guest@mytutor.com";
}
include_once("db_connect.php");
$sqlcourses = "SELECT * FROM tbl_subjects";
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $cid = $_GET['cid'];
        // echo $cid;
        $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_id = '$cid'";
        // echo $cid;
        $stmt = $conn->prepare($sqlcourses);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $courses) {
            $cid= $courses['subject_id'];
            $cname = $courses['subject_name'];
            $cdesc = $courses['subject_description'];
            $cprice = $courses['subject_price']; 
            $tid= $courses['tutor_id'];
            $sses = $courses['subject_sessions'];
            $srate = $courses['subject_rating'];
            }
        }
        else{
            echo "<script>alert('No product found')</script>";
            echo "<script>window.location.replace('products.php')</script>";
        }
    }
}else{
    echo "<script>alert('Error')</script>";
    echo "<script>window.location.replace('products.php')</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/menubar.js" defer></script>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


    <title>My Tutor
    </title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-image: url("1.png");
    }

    p {
        font-size: 18px;
    }

    label {
        font-size: 18px;
    }
    input[type=text] {
        width: 130px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        background-image: url('searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        padding: 12px 20px 12px 40px;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }

    input[type=text]:focus {
        width: 100%;
    }
    parse_ini_file.inset {border-style: inset;}

    </style>
</head>

<body style="max-width:1200px;margin:0 auto;">
    <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <a href="index.php" class="w3-bar-item w3-button">Courses</a>
        <a href="tutor.php" class="w3-bar-item w3-button">Tutors</a>
        <a href="#" class="w3-bar-item w3-button">Subcription</a>
        <a href="#" class="w3-bar-item w3-button">Profile</a>

    </div>

    <div>
        <button class="w3-button w3-whgite w3-xlarge" onclick="w3_open()">☰</button>
        <div class="w3-container w3-center">
            <h2>My Tutor</h2>
            <div>Welcome <?php echo $user_email ?></div>

        </div>
    </div>
    <div class=" w3-padding-16"></div>
    <div class="w3-card w3-center w3-content ">
        <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
        <h3>Your Subject</h3>
        <div class="w3-container w3-center">
            <img class="w3-image w3-margin" src="../resources/courses/<?php echo $cid . '.png' ?>"
                style="height:100%;width:400px"><br>
        </div>
        <form class="w3-container w3-borderw3-padding-12 w3-white">
            <p>
                <label><b>Subject Name </b></label><i class="fas fa-file"></i>
                <?php echo "<p>$cname <p>"?>
            </p>
            <p>
                <label><b>Subject Description </b></label><i class="fas fa-pen"></i>
                <?php echo "<p>$cdesc <p>"?>
            </p>
            <p>
                <label><b>Subject Price </b></label><i class="fas fa-money"></i>
                <?php echo "<p>RM $cprice <p>"?>
            </p>
            <p>
                <label><b>Subject Sessions </b></label><i class="fas fa-book"></i>
                <?php echo "<p>$sses <p>"?>
            </p>
            <p>
                <label><b>Subject Rating </b></label><i class="fas fa-star"></i>
                <?php echo "<p>$srate <p>"?>
                
            </p>
        </form>
    </div>
    </div>


    <footer class="w3-footer w3-center w3-brown">
        <p>
            Copyright © 2019 MyTutorWong
        </p>

    </footer>
</body>

</html>