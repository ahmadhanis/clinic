<?php
session_start();
if ($_SESSION["session_id"]) {
    if(isset($_GET["icno"])) {
        $icno = $_GET["icno"];
    }
    if (isset($_POST['submit'])) {
        if (!(isset($_POST["payment"]) || isset($_POST["remarks"]))) {
            echo "<script> alert('Please fill in all required information')</script>";
            echo "<script> window.location.replace('newvisit.php')</script>";
        } else {
            include_once("dbconnect.php");
            $icno = $_POST["icno"];
            $remarks = $_POST["remarks"];
            $payment = $_POST["payment"];
            $sqlinsertvisit = "INSERT INTO `tbl_visits`(`icno`, `remarks`, `payment`) VALUES('$icno', '$remarks', '$payment')";
            try {
                $conn->exec($sqlinsertvisit);
                echo "<script>alert('Successful')</script>";
                echo "<script>window.location.replace('patdetails.php?icno=$icno')</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Failed')</script>";
                echo "<script>window.location.replace('newvisit.php?icno=$icno')</script>";
            }
        }
    }
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
        <h2>New Visit Form</h2>

        <div class="main-landing">
            <div class="container-patient">
                <form name="visitForm" action="newvisit.php"  onsubmit="return newVisitDialog()" method="post">
                    <center>
                        <div class="row">
                            <div class="col-25">
                                <label for="lname">IC/ID no</label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="idic" name="icno" value="<?php echo $icno; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lcharge">Charge(RM)</label>
                            </div>
                            <div class="col-75">
                                <input type="number" step="any" id="idpayment" name="payment" placeholder="Payment(RM)" value="0.00" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="laddress">Remarks</label>
                            </div>
                            <div class="col-75">
                                <textarea type="text" cols="110%" rows="8" id="idremark" name="remarks" resize="none" placeholder="Patient remarks" required></textarea>
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

        <div class="bottomnavbar">
            <a href="mainpage.php">Home</a>
            <a href="news.php">News</a>
            <a href="contactus.php">Contact us</a>
        </div>

</body>

</html>