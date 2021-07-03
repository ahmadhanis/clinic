<?php
session_start();
include_once("dbconnect.php");

if ($_SESSION["session_id"]) {
    if (isset($_GET["icno"])){
        $icno = $_GET["icno"];
    }
    if (isset($_POST["icno"])){
        $icno = $_POST["icno"];
    }
    if (isset($_POST['submit'])) {
        $submit = $_POST['submit'];
        if ($submit == "Submit") {
            if (!(isset($_POST["icno"]) || isset($_POST["name"]) || isset($_POST["address"]) || isset($_POST["citizenship"]) || isset($_POST["email"]) || isset($_POST["phone"]))) {
                echo "<script> alert('Please fill in all required information')</script>";
                echo "<script> window.location.replace('newpatient.php')</script>";
            } else {
                if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
                    $icno = $_POST["icno"];
                    $name = $_POST["name"];
                    $address = $_POST["address"];
                    $citizenship = $_POST["citizenship"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $sqlupdatepatient = "UPDATE `tbl_patients` SET name = '$name', address = '$address', email = '$email', phone = '$phone', citizenship = '$citizenship' WHERE icno = '$icno'";
                    try {
                        $conn->exec($sqlupdatepatient);
                        uploadImage($icno);
                        echo "<script>alert('Successful')</script>";
                        echo "<script>window.location.replace('mainpage.php')</script>";
                    } catch (PDOException $e) {
                        echo "<script>alert('Failed')</script>";
                        echo "<script>window.location.replace('newpatient.php')</script>";
                    }
                } else {
                    $icno = $_POST["icno"];
                    $name = $_POST["name"];
                    $address = $_POST["address"];
                    $citizenship = $_POST["citizenship"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                   $sqlupdatepatient = "UPDATE `tbl_patients` SET name = '$name', address = '$address', email = '$email', phone = '$phone', citizenship = '$citizenship' WHERE icno = '$icno'";
                    try {
                        $conn->exec($sqlupdatepatient);
                        echo "<script>alert('Successful')</script>";
                       echo "<script>window.location.replace('mainpage.php')</script>";
                    } catch (PDOException $e) {
                        echo "<script>alert('Failed')</script>";
                        echo "<script>window.location.replace('updatepatient.php?icno=$icno')</script>";
                    }
                }
            }
        }
    }
    $sqlpatient = "SELECT * FROM tbl_patients WHERE icno = '$icno'";
    $stmtpat = $conn->prepare($sqlpatient);
    $stmtpat->execute();
    $resultvisit = $stmtpat->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmtpat->fetchAll();
    foreach ($row as $patient) {
        $name = $patient['name'];
        $address = $patient['address'];
        $citizenship = $patient['citizenship'];
        $email = $patient['email'];
        $phone = $patient['phone'];
        $date_reg = $patient['date_reg'];
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
        <h2>Update Patient Form</h2>

        <div class="main-landing">
            <div class="container-patient">
                <form name="updateuserForm" action="updatepatient.php" onsubmit="return updatePatientDialog()" method="post" enctype="multipart/form-data">
                    <center>
                        <div class="row-single">
                            <img class="imgselection" src="../images/patients/<?php echo $icno?>.png" onerror=this.onerror=null;this.src="../images/patients/profile.png"><br>
                            <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="fname">Name</label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="idname" name="name" placeholder="Patient name.." value = "<?php echo $name; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lic">IC No/ID/Passport</label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="idic" name="icno" placeholder="IC/ID number" value="<?php echo $icno; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lname">Email</label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="idemail" name="email" value="<?php echo $email; ?>" placeholder="Patient email if available/ Write 'NA' if not available" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lphone">Phone</label>
                            </div>
                            <div class="col-75">
                                <input type="tel" id="idphone" name="phone" placeholder="Your phone number.." value="<?php echo $phone; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="citizen">Citizenship</label>
                            </div>
                            <div class="col-75">
                            <?php
                                echo "<select name='citizenship' id='citizenid'>
                                <option value='Malaysia'" . ($citizenship == 'Malaysia' ? ' selected' : '') . ">Malaysia</option>
                                <option value='Indonesia'" . ($citizenship == 'Indonesia' ? ' selected' : '') . ">Indonesia</option>
                                <option value='Thailand'" . ($citizenship == 'Thailand' ? ' selected' : '') . ">Thailand</option>
                                <option value='Bangladesh'" . ($citizenship == 'Bangladesh' ? ' selected' : '') . ">Bangladesh</option>
                                <option value='China'" . ($citizenship == 'China' ? ' selected' : '') . ">China</option>
                                <option value='India'" . ($citizenship == 'India' ? ' selected' : '') . ">India</option>
                                <option value='Others'" . ($citizenship == 'Others' ? ' selected' : '') . ">Others</option>
                                </select>";
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="faddress">Address</label>
                            </div>
                            <div class="col-75">
                                <textarea type="text" cols="110%" rows="5" id="idaddress" name="address" resize="none" placeholder="Patient Address" required><?php echo $address; ?></textarea>
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