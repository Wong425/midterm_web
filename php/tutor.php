<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
}else{
    $user_email = "guest@mytutor.com";
}
include_once("db_connect.php");
     $sqltutors = "SELECT * FROM tbl_tutors";


     $results_per_page = 10;
     if (isset($_GET['pageno'])) {
          $pageno = (int)$_GET['pageno'];
         $page_first_result = ($pageno - 1) * $results_per_page;
     } else {
          $pageno = 1;
         $page_first_result = 0;
     }

$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutors = $sqltutors . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn= null;

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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


    <title>My Tutor
    </title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-image: url("1.png");
    }
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
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $tutors) {
            $i++;
            $tid = $tutors['tutor_id'];
            $temail = $tutors['tutor_email'];
            $tphone = $tutors['tutor_phone'];
            $tname = truncate($tutors['tutor_name'],15);
            $tpass = $tutors['tutor_password'];
            $tdes = $tutors['tutor_description'];
            $tdate = $tutors['tutor_datereg'];
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-brown'><h5><b>$tname</b></h5></header>";
            echo "<a href='indexphp.php?tid=$tid' style='text-decoration: none;'> <img class='w3-image' src=../resources/tutors/$tid.jpg" .
                " onerror=this.onerror=null;this.src='../resouces/profile.jpg'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container'><p>Name: $tname<br>Description: $tdes<br>Phone No: $tphone<br>Email: $temail
            </div>
            </div>";
        }
        ?>
    </div>
    <br>
    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "index.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    <br>
</body>

<footer class="w3-footer w3-center w3-brown">
    <p>
        Copyright © 2019 MyTutorWong
    </p>

</footer>


</html>