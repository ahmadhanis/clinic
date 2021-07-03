<?php
session_start();
include_once("dbconnect.php");

if ($_SESSION["session_id"]) {
    if (isset($_POST['submit']) == "Submit") {
        $news = $_POST["news"];
        $sqlinsertvisit = "INSERT INTO `tbl_news`(`news`) VALUES('$news')";
        try {
            $conn->exec($sqlinsertvisit);
            echo "<script>alert('Successful')</script>";
            echo "<script>window.location.replace('news.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Failed')</script>";
            echo "<script>window.location.replace('news.php')</script>";
        }
    }
    if (isset($_GET['submit']) == "Delete") {
        $newsid = $_GET["newsid"];
        $sqldelete = "DELETE FROM tbl_news WHERE newsid = '$newsid'";
        try {
            $conn->exec($sqldelete);
            echo "<script>alert('Successful')</script>";
            echo "<script>window.location.replace('news.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Failed')</script>";
            echo "<script>window.location.replace('news.php')</script>";
        }
    }
    $sqlnews = "SELECT * FROM tbl_news ORDER BY newsdate DESC";
    $results_per_page = 20;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    } else {
        $pageno = 1;
        $page_first_result = ($pageno - 1) * $results_per_page;
    }

    $stmtnews = $conn->prepare($sqlnews);
    $stmtnews->execute();
    $number_of_result = $stmtnews->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);

    $sqlnews = $sqlnews . " LIMIT $page_first_result , $results_per_page ";
    $stmta = $conn->prepare($sqlnews);
    $stmta->execute();
    $resultall = $stmta->setFetchMode(PDO::FETCH_ASSOC);
    $rowsall = $stmta->fetchAll();

} else {
    echo "<script> alert('Session not available. Please login')</script>";
    echo "<script> window.location.replace('../login.php')</script>";
}

function uploadImage($email)
{
    $target_dir = "../images/patients/";
    $target_file = $target_dir . $email . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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
        <h2>News Form</h2>

        <div class="main-landing">
            <div class="container-patient">
                <form name="newsForm" action="news.php" onsubmit="return insertDialog()" method="post">
                    <center>
                        <div class="row">
                            <div class="col-25">
                                <label for="laddress">News</label>
                            </div>
                            <div class="col-75">
                                <textarea type="text" cols="110%" rows="8" id="idremark" name="news" resize="none" placeholder="New News" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </center>
                </form>

            </div>
            <a href="mainpage.php" class="float">
                <i class="fa fa-close my-float"></i>
            </a>
        </div>
        <?php
        echo "<div class='card-visit'>";
        $i = 1;
        foreach ($rowsall as $news) {
            $newsid = $news['newsid'];
            $del = "Delete";
            echo "<div class='card'>";
            echo "<table style='width:100%'>";
            echo "<tr><td style='width:30%'>No: </td><td style='width:70%'>" . ($i++) . "</td></tr>";
            echo "<tr><td style='width:30%'>News Date: </td><td style='width:70%'>" . date_format(date_create($news['newsdate']), 'd/m/y H:i A') . "</td></tr>";
            echo "<tr><td style='width:30%'>News: </td><td style='width:70%'>" . ($news['news']) . "</td></tr>";
            echo "<tr><td colspan='2'><button onclick='return deleteDialog()'><a href='news.php?newsid=$newsid&submit=$del'>Delete</a></button></td></tr>";
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
                echo '<a href = "news.php?pageno=' . $page . '">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
        ?>

        <div class="bottomnavbar">
            <a href="mainpage.php">Home</a>
            <a href="news.php">News</a>
            <a href="contactus.php">Contact us</a>
        </div>

</body>

</html>