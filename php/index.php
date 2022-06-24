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
     if ($operation == 'search') {
        $search = $_GET['search'];
        $option = $_GET['option'];
        if ($option == "Select") {
            $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
        } else if($option == "lower100") {
            $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_price BETWEEN 0 AND 99";
        }else if($option == "100to200") {
            $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_price BETWEEN 100 AND 200";
        }else if($option == "200above") {
            $sqlcourses = "SELECT * FROM tbl_subjects WHERE subject_price BETWEEN 201 AND 500";
        }
    }
}
 else {
    $sqlcourses = "SELECT * FROM tbl_subjects";
}

     $results_per_page = 10;
     if (isset($_GET['pageno'])) {
          $pageno = (int)$_GET['pageno'];
         $page_first_result = ($pageno - 1) * $results_per_page;
     } else {
          $pageno = 1;
         $page_first_result = 0;
     }

$stmt = $conn->prepare($sqlcourses);
$stmt->execute();
$number_of_result = $stmt->rowCount();
// echo $number_of_result;
$number_of_page = ceil($number_of_result / $results_per_page);
// echo $number_of_page;
$sqlcourses = $sqlcourses . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlcourses);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


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
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3 class="w3-center">Subject Search</h3>
        <form>
            <div class="w3-row">
                <div class="w3-rest" style="padding-right:4px">
                    <input class="w3-hover-pale-yellow" type="text" name="search" placeholder="Search..">
                </div>
                <div class="w3-rest" style="padding-right:4px">
                    <p> <select class="w3-input w3-hover-pale-yellow w3-block w3-round w3-border" name="option">
                            <option value="Select" selected>Select</option>
                            <option value="lower100">Lower than RM100</option>
                            <option value="100to200">Between RM100 & RM200</option>
                            <option value="200above">RM200 above</option>
                        </select>
                    </p>
                </div>
            </div>
            <button class="w3-button w3-topbar w3-bottombar w3-border-brown w3-hover-pale-yellow w3-right" type="submit" name="submit"
                value="search">search</button></p>
    </div>
    </form>

    </div>
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $courses) {
            $i++;
            $cid= $courses['subject_id'];
            $cname = truncate($courses['subject_name'],20);
            $cdesc = $courses['subject_description'];
            $cprice = number_format((float)$courses['subject_price'], 2, '.', ''); 
            $tid= $courses['tutor_id'];
            $sses = $courses['subject_sessions'];
            $srate = $courses['subject_rating'];
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-brown'><h5><b>$cname</b></h5></header>";
            echo "<button class='w3-rest'><a href='details.php?submit=details&cid=$cid' style='text-decoration: none;'> <img class='w3-image' src=../resources/courses/$cid.png" .
                " onerror=this.onerror=null;this.src='../resouces/profile.jpg'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container'><p>Descripton: $cdesc<br>Price: RM $cprice<br>Tutor ID: $tid
            <br>Sessions: $sses<br>Rating: $srate<br><div class='w3-button w3-brown w3-round w3-block' onClick='addCart($tid)'>Add to Cart</div></p></div>
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