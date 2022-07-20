<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
session_start();
error_reporting(0);
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You are already logged in. Please log out to create a new acount.');
    window.location.href='view.php';
    </script>");
    exit;
}

if(isset($_POST['f1']))
{
    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server, $username, $password);

    if(!$con){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    
    
    $name = $_POST['f1'];
    $email = $_POST['f2'];
    $dob = $_POST['f3'];
    $pass = $_POST['f4'];
    $cpass = $_POST['f5'];
    $roleV = $_POST['f6'];
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

      } else 
      if($dob==""){
        echo ' <div class="alertcontr">
        <strong>DOB Error!</strong> DOB cannot be left empty.
        </div> ';}

    


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
      else if($roleV==""){
        echo ' <div class="alertcontr">
            <strong>Role Error!</strong> Please select a role for yourself.
            </div> ';
      }
      else {
    $sqlc = "SELECT * FROM `creds`.`data` WHERE name = '$name' ";
    $result = mysqli_query($con, $sqlc);

    $num = mysqli_num_rows($result);

    $sqlcz = "SELECT * FROM `creds`.`data` WHERE email = '$email' ";
    $resultz = mysqli_query($con, $sqlcz);

    $numz = mysqli_num_rows($resultz);
    if($num>0){
        echo ' <div class="alertcontr">
  <strong>Username Error!</strong> An account with this username already exists. Please choose a different username.
</div> ';
    }
    else if($numz>0){
        echo ' <div class="alertcontr">
  <strong>Email Error!</strong> An account with this email already exists. Please use a different email.
</div> ';
    }
    else{
    $sql = " INSERT INTO `creds`.`data` (`name`, `email`, `dob`, `pass`, `role`, `dt`) VALUES ('$name', '$email', '$dob', '$hash', '$roleV', current_timestamp());";

    if($con->query($sql) == true){
        // header("Location: login.html");
        echo ' <div class="alertcontg">
    <strong>Successfully registered!</strong> Login to continue.
    <script LANGUAGE="JavaScript">
    setTimeout(function(){
        window.location.href="login.php";
     }, 2000);
    </script>
  </div> ';
    }
    else{
        echo "Error : $sql <br> $con->error";
    }
    $con->close();
    }
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup1.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=The+Nautigal&display=swap" rel="stylesheet">
    <title>SignUp Page</title>
    
</head>
<body>
    <!-- <form name="valiform" onsubmit="return finalc()" method="post"> -->
    <form action="" method="post">
        <div class="Container" >
            <h1 id="Heading">Sign Up</h1>
            <label id="SHeading">It's quick and easy.</label>
            <div>
                <label id="uName">User Name  :</label>
                <input type="text" name="f1" id="uNameV" placeholder="Enter you Username" >
            </div>
            <div>
                <label id="email">Email      :</label>
                <input type="email" name="f2" id="emailV" placeholder="Enter you Email" >
            </div>
            <div>
                <label id="DOB">DOB        :</label>
                <input type="date" name="f3" id="DOBV" >
            </div>
            <div>
                <label id="pass">Password  :</label>
                <input type="password" name="f4" id="passV" placeholder="********" >
            </div>
            <div>
                <label id="cPass">Confirm Password  :</label>
                <input type="password" name="f5" id="cPassV" placeholder="********" >
            </div>
            <div>
                <label id="role" >Acess Level : </label>
                <select name="f6" id="roleV">
                  <option value="" disabled selected hidden>Select your Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
               </div> 
               
            <div>
                 <!-- <button  id="BT" onClick="Check()">Register</button> 
                 -->
                 <input type="submit"  id="BT" value="Save" name="submit" ></input> 
            </div>
            <div>
                <a href="login.php">Already a User? Log In</a>
            </div>
        </div>
    </form>
        
    </script>
   
</body>
</html>

