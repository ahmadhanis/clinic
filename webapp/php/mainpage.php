<?php
session_start();
include_once("dbconnect.php");
if ($_SESSION["session_id"]) {
    if (isset($_GET['icno'])) {
        $icno = $_GET['icno'];
        $sqldelete = "DELETE FROM tbl_patients WHERE icno = '$icno'";
        $stmt = $conn->prepare($sqldelete);
        if ($stmt->execute()) {
            echo "<script> alert('Delete Success')</script>";
        } else {
            echo "<script> alert('Delete Failed')</script>";
        }
    }
    if (isset($_GET['button'])) {
        $option = $_GET['option'];
        $search = $_GET['search'];
        if ($option == "name") {
            $sqlpatients = "SELECT * FROM tbl_patients WHERE name LIKE '%$search%'";
        }
        if ($option == "ic") {
            $sqlpatients = "SELECT * FROM tbl_patients WHERE icno LIKE '%$search%'";
        }
        if ($option == "today") {
            //$sqllistquestions = "SELECT * FROM tbl_questions_mcq INNER JOIN tbl_user ON tbl_questions_mcq.user_email = tbl_user.email WHERE tbl_questions_mcq.form = '$yearform' AND tbl_questions_mcq.subject_name = '$subject' AND tbl_questions_mcq.question LIKE '%$searchkey%' ORDER BY tbl_questions_mcq.date_created DESC";
            $sqlpatients = "SELECT * FROM tbl_patients INNER JOIN tbl_visits ON tbl_visits.icno=tbl_patients.icno WHERE DATE(tbl_visits.date_visit) = CURDATE()";
        }
    } else {
        $sqlpatients = "SELECT * FROM tbl_patients ORDER BY date_reg DESC";
    }
    $results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];

        $page_first_result = ($pageno - 1) * $results_per_page;
        // $sqlpatients = $sqlpatients . " LIMIT $page_first_result , $results_per_page";
    } else {
        $pageno = 1;
        $page_first_result = ($pageno - 1) * $results_per_page;
        //  $sqlpatients = $sqlpatients . " LIMIT $page_first_result , $results_per_page";
    }


    $stmt = $conn->prepare($sqlpatients);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);

    $sqlpatients = $sqlpatients . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqlpatients);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
} else {
    echo "<script> alert('Session not available. Please login')</script>";
    echo "<script> window.location.replace('../login.php')</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Unique Clinic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/myscript.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="header">
        <h1>Klinik Gigi Unique</h1>
        <p>Aplikasi Pengurusan Klinik</p>
    </div>
    <div class="topnavbar" id="myTopnav">
        <a href="../login.php?status=logout" onclick="logout()" class="right">Logout</a>
    </div>
    <center>
        <h2>Patients List</h2>
        <div class="container">
            <form action="mainpage.php" align="center">
                <div class="selectsearch">
                    <input type="search" id="idsearch" name="search" placeholder="Enter search term" />
                    <select name="option" id="srcid">
                        <option value="name">By Name</option>
                        <option value="ic">By IC</option>
                        <option value="today">Today</option>
                    </select>
                    <button type="submit" name="button" value="search">search</button>
                </div>
            </form>
        </div>
    </center>
    <div class="main-landing">
        <center>
            <?php

            echo "<div class='card-names'>";
            foreach ($rows as $patient) {
                $icno = $patient['icno'];
                echo "<div class='card' style='overflow-x:auto;text-align:center;'>";
                echo "<table><tr><td style='width:35%'; ><img class='profileimg' src=../images/patients/" . $patient['icno'] . ".png" . " onerror=this.onerror=null;this.src='../images/patients/profile.png'" . "></td>";
                echo "<td style='width:65%'>";
                echo "<table style='width:100%'>";
                echo "<tr><td style='width:30%'>Name: </td><td style='width:70%'>" . ($patient['name']) . "</td></tr>";
                echo "<tr><td style='width:30%'>IC No: </td><td style='width:70%'>" . ($patient['icno']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Phone: </td><td style='width:70%'>" . ($patient['phone']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Citizenship: </td><td style='width:70%'>" . ($patient['citizenship']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Register: </td><td style='width:70%'>" . date_format(date_create($patient['date_reg']), 'd/m/y H:i A') . "</td></tr>";
                echo "<tr><td colspan='2'><button onclick='return deleteDialog()'><a href='mainpage.php?icno=$icno'>Delete</a></button>&nbsp&nbsp
                <button onclick=''><a href='updatepatient.php?icno=$icno'>Update</a></button>&nbsp&nbsp
                <button onclick=''><a href='patdetails.php?icno=$icno'>Details</a></button></td></tr>";
                echo "</table>";
                echo "</td></tr></table>";
                echo "</div>";
            }
            echo "</div>";
            ?>
        </center>
        <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='row-pages'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "mainpage.php?pageno=' . $page . '">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>
        <a href="newpatient.php" class="float">
            <i class="fa fa-plus my-float"></i>
        </a>
    </div>

    <div class="bottomnavbar">
        <a href="news.php">News</a>
        <a href="contactus.php">Contact us</a>
    </div>

</body>

</html>