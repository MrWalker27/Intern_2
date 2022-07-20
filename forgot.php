<?php

session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You are curently logged in.');
    window.location.href='view.php';
    </script>");
    exit;
}

if(isset($_POST['f1'])){
// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "creds";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
$name = $_POST['f1'];
$email = $_POST['f2'];
$pass = $_POST['f3'];
$cpass = $_POST['f4'];
$hash = password_hash($pass, PASSWORD_DEFAULT);
if($name =="") {
    echo ' <div class="alertcontr">
    <strong>Username Error!</strong> You did not enter a name.
    </div> ';
  }
  else if(!preg_match("/^([a-zA-Z' ]+)$/", $name)){
    echo ' <div class="alertcontr">
    <strong>Username Error!</strong> Please enter a valid name.
    </div> ';
} 
else if($email == ""){
    echo ' <div class="alertcontr">
<strong>Email Error!</strong> Email cannot be left empty.
</div> ';
} else if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)){
    echo ' <div class="alertcontr">
<strong>Email Error!</strong> Please enter a valid e-mail address.
</div> ';

  }
  else if($pass ==""){
    echo ' <div class="alertcontr">
    <strong>Password Error!</strong> Password cannot be left empty.
    </div> ';
  }
  else if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/", $pass)){
    echo ' <div class="alertcontr">
    <strong>Password Error!</strong> Please enter a valid password.
    </div> ';
  }

  else if($cpass != $pass){
    
        echo ' <div class="alertcontr">
        <strong>Password Error!</strong> Your confirmed password does not match.
        </div> ';
  }
  else{


$sql = "SELECT * FROM `data` WHERE name = '$name' and email='$email'";
$result = mysqli_query($conn, $sql);


$num = mysqli_num_rows($result);
if($num==0){
    echo ' <div class="alertcontr">
  <strong>Invalid Credentials!</strong> Username and Email does not match.
</div> ';
}
if($num == 1){
    
        $sql2 = "UPDATE `data` SET `pass`='$hash' WHERE name = '$name' and email='$email'";
        $result2 = mysqli_query($conn, $sql2);
        echo ' <div class="alertcontg">
    <strong>Password Updated Successfully!</strong> Login to continue.
    <script LANGUAGE="JavaScript">
    setTimeout(function(){
        window.location.href="login.php";
     }, 2000);
    </script>
  </div> ';
   
        
    }
}

}




?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="forgot1.css"/>
        <title>Forgot Password</title>
    </head>
    <body>
        
        <form method="post" action="">
            <div class="container">
                <h1 id="Heading">Forgot Password</h1>
                <div>
                    <label id="uName">User Name  :</label>
                    <input type="text" name="f1" id="uNameV" placeholder="Enter your Username" >
                </div>
                <div>
                    <label id="email">Email  :</label>
                    <input type="email" name="f2" id="emailV" placeholder="Enter the email associated" >
                </div>
                <div>
                    <label id="pass">New Password  :</label>
                    <input type="password" name="f3" id="passV" placeholder="********" >
                </div>
                <div>
                    <label id="cPass">Confirm Passowrd  :</label>
                    <input type="password" name="f4" id="cpassV" placeholder="********" >
                </div>
                <div>
                    <button type="submit" name="login" value="Login"id="BT" style="margin-top:-0.1em;">Update</button>
                </div>
                <div style="margin-bottom: 2em;">
                    <a href="signup.php" style="margin-right: 11em;">New User?</a>
                    <a href="login.php">Remember Now?</a>
                </div>
            </div>
        </form>
        
    </script>
    </body>
</html>

