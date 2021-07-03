<?php
session_start();
if ($_SESSION["session_id"]) {
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
        <h2>Contact US</h2>

        <div class="main-landing">
            
        </div>

        <div class="bottomnavbar">
            <a href="mainpage.php">Home</a>
            <a href="news.php">News</a>
            <a href="contactus.php">Contact us</a>
        </div>

</body>

</html>