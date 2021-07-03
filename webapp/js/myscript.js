function validateLoginForm() {
    var email = document.forms["loginForm"]["idemail"].value;
    var pass = document.forms["loginForm"]["idpass"].value;
    if ((email === "") || (pass === "")) {
        alert("Please fill out your username/password");
        return false;
    }
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(email))) {
        alert("Please correct your email");
        return false;
    }
    setCookies(10);
}

function validateNewQForm() {
    var answer = document.forms["questionForm"]["idanswer"].value;
    console.log(answer);
    if (answer === "noselection") {
        alert("Please select your answer");
        return false;
    } else {
        return true;
    }
}
function mytopnavFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnavbar") {
        x.className += " responsive";
    } else {
        x.className = "topnavbar";
    }
}

function validateRegForm() {
    var email = document.forms["registerForm"]["idemail"].value;
    var pass = document.forms["registerForm"]["idpass"].value;
    if ((email === "") || (pass === "")) {
        alert("Please fill out your username/password");
        return false;
    }
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(email))) {
        alert("Please correct your email");
        return false;
    }
    var r = confirm("Register this patient?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
function validateUpdForm() {
    var r = confirm("Update your profile?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}


function setCookies(exdays) {
    var email = document.forms["loginForm"]["idemail"].value;
    var pass = document.forms["loginForm"]["idpass"].value;
    var rememberme = document.forms["loginForm"]["idremember"].checked;
    console.log(email, pass, rememberme);
    if (rememberme) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = "cusername=" + email + ";" + expires + ";path=/";
        document.cookie = "cpass=" + pass + ";" + expires + ";path=/";
        document.cookie = "rememberme=" + rememberme + ";" + expires + ";path=/";

    } else {
        document.cookie = "cusername=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
        document.cookie = "cpass=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
        document.cookie = "rememberme=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function loadCookies() {
    var username = getCookie("cusername");
    var password = getCookie("cpass");
    var rememberme = getCookie("rememberme");
    console.log("COOKIES:" + username, password, rememberme);
    document.forms["loginForm"]["idemail"].value = username;
    document.forms["loginForm"]["idpass"].value = password;
    if (rememberme) {
        document.forms["loginForm"]["idremember"].checked = true;
    } else {
        document.forms["loginForm"]["idremember"].checked = false;
    }
}

function logout() {
    var r = confirm("Logout?");
    if (r == true) {W
        alert('Log out success');
        //Wwindow.location.replace('../php/login.php?status=logout');
        return true;
    } else {
        return false;
    }
}

function deleteDialog() {
    var r = confirm("Delete this data?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
function newVisitDialog() {
    var r = confirm("Insert this visit?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function insertDialog() {
    var r = confirm("Insert this data?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function updatePatientDialog() {
    var r = confirm("Update?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function updateVisitDialog() {
    var r = confirm("Update this visit?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
function updateDialog() {
    var answer = document.forms["editquestionForm"]["idanswer"].value;
    console.log(answer);
    if (answer === "noselection") {
        alert("Please select your answer");
        return false;
    }
    var r = confirm("Update this question?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function previewFile() {
    const preview = document.querySelector('.imgselection');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();
    reader.addEventListener("load", function () {
        // convert image file to base64 string
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function goBack() {
    window.history.back();
}

function myReadMore() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");
  
    if (dots.style.display === "none") {
      dots.style.display = "inline";
      //btnText.innerHTML = "Read more"; 
      moreText.style.display = "none";
    } else {
      dots.style.display = "none";
      //btnText.innerHTML = "Read less"; 
      moreText.style.display = "inline";
    }
  }

  