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
    window.alert('You dont have the required permission to view this page');
    window.location.href='view.php';
    </script>");
    exit;
 
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
        <title>Delete Page</title>
    </head>
    <body>
        
        <form method="post"  action="">
            <div class="container" id="cont">

            <div class="info">
            <h1 id="Heading" >Current User: <?php echo $_SESSION['name']?></h1>
                <h1 id="Heading" style="margin-top: 0em; margin-bottom: 1em">Permission level: <?php echo $_SESSION['role']?></h1>
                <input type="submit"  id="BT1" value="Delete" name="submit" ></input> 
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
                <!-- <th class="role" style="font-size: 20px;">Role</th> -->
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                $sn=1;
                while($data = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="row1">
                <!-- <td class="sno" ><?php echo $sn; ?></td> -->
                <td class="uname2"><?php echo $data['name']; ?></td>
                <td class="mail2"><?php echo $data['email']; ?></td>
                <td class="dob2"><?php echo $data['dob']; ?></input></td>
                <!-- <td class="role"><?php echo $data['role']; ?> </td> -->
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
if($_POST['submit'])
{      

        $query = "DELETE FROM data WHERE name = '$nm' ";
        $data=mysqli_query($conn, $query);

if($data)
{
    echo ' <div class="alertcontg1">
  <strong>Success!</strong> Record Deleted succesfully.
  <script LANGUAGE="JavaScript">
  setTimeout(function(){
    window.location.href="update.php";
 }, 2000);
 </script>
</div> ';
}
else{
    echo ' <div class="alertcontr1">
  <strong>Error!</strong> Record failed to delete.
  <script LANGUAGE="JavaScript">
  setTimeout(function(){
    window.location.href="update.php";
 }, 2000);
 </script>
</div> ';
}
}
    ?>