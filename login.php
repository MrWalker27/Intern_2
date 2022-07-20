<?php

session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You are already logged in.');
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
$pass = $_POST['f2'];


// $sql = "SELECT * FROM `data` WHERE name = '$name' AND pass = '$pass' ";
$sql = "SELECT * FROM `data` WHERE name = '$name'";
$result = mysqli_query($conn, $sql);


$num = mysqli_num_rows($result);
if($num==0){
    echo ' <div class="alertcontr">
  <strong>Invalid Credentials!</strong> Try again.
</div> ';
}
if($num == 1){
    while($row=mysqli_fetch_assoc($result)){
        if(password_verify($pass, $row['pass'])){
            session_start();
    $_SESSION['loggedin']=true;
    $_SESSION['name']=$name;
    $_SESSION['role']=$row['role'];
    
    header("Location: view.php");
        }
        else{
            echo ' <div class="alertcontr">
  <strong>Invalid Credentials!</strong> Try again.
</div> ';
        }
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
        <link rel="stylesheet" href="login.css"/>
        <title>Login Page</title>
    </head>
    <body>
        
        <form method="post" action="login.php">
            <div class="container">
                <h1 id="Heading">LogIn</h1>
                <div>
                    <label id="uName">User Name  :</label>
                    <input type="text" name="f1" id="uNameV" placeholder="Enter you Username" required>
                </div>
                <div>
                    <label id="pass">Password  :</label>
                    <input type="password" name="f2" id="passV" placeholder="********" required>
                </div>
                <div>
                    <button type="submit" name="login" value="Login"id="BT">Login</button>
                </div>
                <div>
                    <a href="signup.php" style="margin-right: 2em;">New User?</a>
                    <a href="forgot.php" style="margin-left: 12em;">Forgot Passowrd?</a>
                </div>
            </div>
        </form>
        
    </script>
    </body>
</html>

