<?php
session_start();
include_once("dbconnect.php");
if ($_SESSION["session_id"]) {
    $icno = $_GET['icno'];
    if (isset($_GET['submit'])){
        $submit = $_GET['submit'];
        if ($submit =="delete"){
            $vid = $_GET['vid'];
            $sqldelete = "DELETE FROM tbl_visits WHERE visit_id = '$vid'";
            $stmt = $conn->prepare($sqldelete);
            if ($stmt->execute()) {
                echo "<script> alert('Delete Success')</script>";
            } else {
                echo "<script> alert('Delete Failed')</script>";
            }
        }
    }
    $sqlpatients = "SELECT * FROM tbl_patients WHERE icno = '$icno'";
    $stmt = $conn->prepare($sqlpatients);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    $sqlvisits = "SELECT * FROM tbl_visits WHERE icno = '$icno' ORDER BY date_visit DESC ";
    $results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
      $page_first_result = ($pageno - 1) * $results_per_page;
       // $sqlvisits = $sqlvisits . " LIMIT $page_first_result , $results_per_page";
    }else{
        $pageno = 1;
        $page_first_result = ($pageno - 1) * $results_per_page;
      //  $sqlvisits = $sqlvisits . " LIMIT $page_first_result , $results_per_page ";
    }
    
    $stmtvisit = $conn->prepare($sqlvisits);
    $stmtvisit->execute();
    $number_of_result = $stmtvisit->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    
    $sqlvisits = $sqlvisits . " LIMIT $page_first_result , $results_per_page ";
    $stmtvisit = $conn->prepare($sqlvisits);
    $stmtvisit->execute();
    $resultvisit = $stmtvisit->setFetchMode(PDO::FETCH_ASSOC);
    $rowsvisit = $stmtvisit->fetchAll();
   
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
        <h2>Patient Details</h2>
    </center>
    <center>
        <div class="row-single">
            <div class="card-header">
                <?php
                foreach ($rows as $patient) {
                    $name = $patient['name'];
                    $icno = $patient['icno'];
                    $address = $patient['address'];
                    $citizenship = $patient['citizenship'];
                    $email = $patient['email'];
                    $phone = $patient['phone'];
                }
                echo "<div class='row'>";
                echo " <div class='col-25' style='overflow-x:auto;text-align:center;'>";
                echo "<img class='profileimgpat' src=../images/patients/" . $patient['icno'] . ".png"." onerror="."this.onerror=null;this.src='../images/patients/profile.png'".">";
                echo "</div>";
                echo " <div class='col-75' style='overflow-x:auto;'>";
                echo "<table style='width:100%' >";
                echo "<tr><td style='width:30%'>Name: </td><td style='width:70%'>" . $name . "</td></tr>";
                echo "<tr><td style='width:30%'>IC No: </td><td style='width:70%'>" . ($patient['icno']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Phone: </td><td style='width:70%'>" . ($patient['phone']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Email: </td><td style='width:70%'>" . ($patient['email']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Citizenship: </td><td style='width:70%'>" . ($patient['citizenship']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Address: </td><td style='width:70%'>" . ($patient['address']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Register: </td><td style='width:70%'>" . date_format(date_create($patient['date_reg']), 'd/m/y H:i A') . "</td></tr>";
                echo "</table>";
                echo "</div>";
                echo "</div>";
                ?>
            </div>
        </div>
        <h3>Visits</h3>

        <div class="main-landing">
            <?php
            echo "<div class='card-visit'>";
            $i = 1;
            foreach ($rowsvisit as $visit) {
                $visitid = $visit['visit_id'];
                $del = "delete";
                echo "<div class='card'>";
                echo "<table style='width:100%'>";
                echo "<tr><td style='width:30%'>Visit No: </td><td style='width:70%'>" . ($i++) . "</td></tr>";
                echo "<tr><td style='width:30%'>Date Visit: </td><td style='width:70%'>" . date_format(date_create($visit['date_visit']), 'd/m/y H:i A') . "</td></tr>";
                echo "<tr><td style='width:30%'>Paid: </td><td style='width:70%'> RM" . ($visit['payment']) . "</td></tr>";
                echo "<tr><td style='width:30%'>Remarks: </td><td style='width:70%'>" . ($visit['remarks']) . "</td></tr>";
                echo "<tr><td colspan='2'><button onclick='return deleteDialog()'><a href='patdetails.php?icno=$icno&vid=$visitid&submit=$del'>Delete</a></button>&nbsp&nbsp
                    <button onclick=''><a href='updatevisit.php?icno=$icno&vid=$visitid'>Update</a></button></td></tr>";
                echo "</table>";
                echo "</div>";
            }
            echo "</div>";
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
                echo '<a href = "patdetails.php?pageno=' . $page . '&icno='.$icno.'">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
            echo "<a href='newvisit.php?icno=$icno' class='float'>
                <i class='fa fa-plus my-float'></i></a>";
            ?>
        </div>

        <div class="bottomnavbar">
            <a href="mainpage.php">Home</a>
            <a href="#contact">Contact us</a>
        </div>

</body>

</html>