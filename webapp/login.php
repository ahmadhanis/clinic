<?php
session_start();
if (isset($_POST['submit'])) {
    include_once("php/dbconnect.php");
    $email = trim($_POST['email']);
    $password = trim(sha1($_POST['password']));
    $sqllogin = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";

    $select_stmt = $conn->prepare($sqllogin);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    if ($select_stmt->rowCount() > 0) {
        $_SESSION["session_id"] = session_id();
        echo "<script> alert('Login successful')</script>";
        echo "<script> window.location.replace('php/mainpage.php')</script>";
    } else {
        session_unset();
        session_destroy();
        echo "<script> alert('Login fail')</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
}
if (isset($_GET["status"])) {
    if (($_GET["status"] == "logout")) {
        session_unset();
        session_destroy();
        echo "<script> alert('Session Cleared')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/myscript.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body onload="loadCookies()">
    <div class="header">
        <h1>Klinik Gigi Unique</h1>
        <p>Aplikasi Pengurusan Klinik</p>
    </div>
    <div class="topnavbar" id="myTopnav">
        <a href="login.php" class="right">Home</a>
    </div>
    <div class="main-landing">
        <center>
            <div class="containerlogin">
                <form name="loginForm" action="login.php" onsubmit="return validateLoginForm()" method="post">
                    <img src="logo.png" class="imgresponsive">

                    <div class="row">
                        <div class="col-25">
                            <label for="femail">Email</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="idemail" name="email" placeholder="Your email..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Password</label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="idpass" name="password" placeholder="Your password..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-75" align="left">
                            <input type="checkbox" id="idremember" name="rememberme">
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </center>

    </div>

    <div class="bottomnavbar">
        <a href="#contact">Contact us</a>
    </div>

</body>

</html>