<?php
session_start();
include_once("dbconnect.php");
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim(sha1($_POST['password']));
    $sqllogin = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";

    $select_stmt = $conn->prepare($sqllogin);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    if ($select_stmt->rowCount() > 0) {
        $_SESSION["session_id"] = session_id();
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $row['name'];
        $_SESSION["school"] = $row['school'];
        $_SESSION["phone"] = $row['phone'];
        $_SESSION["datereg"] = $row['date_reg'];
        $_SESSION["pass"] = $row['password'];
        echo "<script> alert('Login successful')</script>";
        echo "<script> window.location.replace('../php/depository.php')</script>";
    } else {
        session_unset();
        session_destroy();
        echo "<script> alert('Login fail')</script>";
        echo "<script> window.location.replace('../php/login.php')</script>";
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
    <script src="../js/depositori.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body onload="loadCookies()">
    <div class="header">
        <h1>Depository for Exam Questions</h1>
        <p>Application for JPN Kedah.</p>
    </div>
    <div class="topnavbar" id="myTopnav">
        <a href="register.php" class="right">Register</a>
    </div>
    <div class="main-landing">
        <center>
            <img src="../images/jpnlogo.png" class="imgresponsive">

            <div class="container">
                <form name="loginForm" action="../php/login.php" onsubmit="return validateLoginForm()" method="post">
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
        <a href="../index.html">Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
    </div>

</body>

</html>