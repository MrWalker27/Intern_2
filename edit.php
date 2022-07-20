<?php
session_start();
error_reporting(0);
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Please Log in First to view this page');
    window.location.href='login.php';
    </script>");
    exit;
}
else if($_SESSION['role']!="admin"){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You dont have the required permission to view this page.');
    window.location.href='view.php';
    </script>");
    exit;
 
}

?>

<?php
if($_POST['submit'])
{   
    $final = 6;
    $name = $_POST['f1'];
    $email = $_POST['f2'];
    $role = $_POST['f3'];

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
  <strong>Email Error!</strong> Email cannot be empty.
</div> ';
    } 
    
    
    
   else if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)){
        echo ' <div class="alertcontr">
  <strong>Email Error!</strong> Please enter a valid e-mail address.
</div> ';
      }
     else if($role =="") {
        echo ' <div class="alertcontr">
  <strong>Role Error!</strong> You did not choose a role.
</div> ';
      }
      else{
        $final =7;
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
        <link rel="stylesheet" href="view1.css"/>
        <link rel="stylesheet" href="edit.css"/>
        <title>Edit Page</title>
    </head>
    <body>
        
        <form method="post"  action="">
            <div class="containerp" id="cont">

            <div class="info2">
            <h1 id="Heading" >Current User: <?php echo $_SESSION['name']?></h1>
                <h1 id="Heading" style="margin-top: 0em; margin-bottom: 1em">Permission level: <?php echo $_SESSION['role']?></h1>
                <input type="submit"  id="BT" value="Save" name="submit" ></input> 
            </div>


                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "creds";
                $nm=$_GET['nm'] ;
                // echo "hello $nm";
                
                $conn = mysqli_connect($servername, $username, $password, $database);
                
                $sql = "SELECT * FROM `data` WHERE name = '$nm' ";
                $result = mysqli_query($conn, $sql);
                
                ?>

                <table border ="1">
                <tr>
                <!-- <th class="sno" style="font-size: 20px;">Sno</th> -->
                <th class="uname" style="font-size: 20px;">UserName</th>
                <th class="mail" style="font-size: 20px;">Email</th>
                <th class="dbo" style="font-size: 20px;">DOB</th>
                <th class="role" style="font-size: 20px;">Role</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                $sn=1;
                while($data = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="row1">
                <!-- <td class="sno" ><?php echo $sn; ?></td> -->
                <td class="uname2"><input id="uNameV" name="f1" style="width: 14em; text-align:center;" value="<?php echo $data['name']; ?>" ></input></td>
                <td class="mail2"><input id="emailV" name="f2" style="width:16em; text-align: center;" value="<?php echo $data['email']; ?>" ></input></td>
                <td class="dob2"><?php echo $data['dob']; ?></input></td>
                <td class="role2">
                <select name="f3" id="roleV" style="width: 10em; text-align:center;">
                  <option value="" disabled selected hidden>Select your Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
                </td>
                <tr>
                <?php
                $sn++;}} else { ?>
                <tr>
                <td colspan="8">No data found</td>
                </tr>
                <?php } ?>
                </table>


                <div style="margin-bottom: 2em;margin-top: 1.5em">
                    <a href="logout.php" style="font-size: 1.3em; ">Log Out</a>
                </div>
             
            </div>
        </form>
     
    </style>
    </body>
    

    
    
</html>

<?php
if(($_POST['submit']) && ($final == 7))
{   
    $name = $_POST['f1'];
    $email = $_POST['f2'];
    $role = $_POST['f3'];

   

        $query = "UPDATE data SET name='$name' , email='$email' , role='$role' WHERE name = '$nm' ";
        $data=mysqli_query($conn, $query);

if($data)
{
    echo ' <div class="alertcontg1">
  <strong>Success!</strong> Record updated succesfully.
  <script LANGUAGE="JavaScript">
  setTimeout(function(){
    window.location.href="update.php";
 }, 2000);
 </script>
</div> ';
}
else{
    echo ' <div class="alertcontr1">
  <strong>Error!</strong> Something went wrong.
  <script LANGUAGE="JavaScript">
  setTimeout(function(){
    window.location.href="update.php";
 }, 2000);
 </script>
</div> ';
}
}
    ?>