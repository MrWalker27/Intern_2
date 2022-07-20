<?php
session_start();
$role = $_SESSION['role'];
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Please Log in First');
    window.location.href='login.php';
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
        <title>View Page</title>
    </head>
    <body>
        
        <form method="post" action="login.php">
            <div class="container" id="cont">

            <div class="info">
            <h1 id="Heading" >Current User: <?php echo $_SESSION['name']?></h1>
                <h1 id="Heading" style="margin-top: 0em; margin-bottom: 1em">Permission level: <?php echo $_SESSION['role']?></h1>
            </div>


                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "creds";
                
                $conn = mysqli_connect($servername, $username, $password, $database);
                
                $num_per_page = 15;

                if(isset($_GET["page"])){
                $page=$_GET["page"];
                }
                else{
                $page=1;
                }

                $start_from=($page-1)*15;

                
                if($_SESSION['role']=="admin")
                $sql = "SELECT * FROM `data`";
                else
                $sql = "SELECT * FROM `data` WHERE role = 'user'";
                $result = mysqli_query($conn, $sql);

                $total_records = mysqli_num_rows($result);
                    $total_pages = ceil($total_records/$num_per_page);
                    ?><div style="position:absolute; margin-top:19em;"></div><?php

                    if($_SESSION['role']=="admin")
                    $sql2 = "SELECT * FROM `data` limit $start_from,$num_per_page";
                     else
                    $sql2 = "SELECT * FROM `data` WHERE role = 'user' limit $start_from,$num_per_page";
                  
                    
                    
                    $result2 = mysqli_query($conn, $sql2);

                ?>
                

                <table border ="1">
                <tr>
                <th class="sno" style="font-size: 20px;">Sno</th>
                <th class="uname" style="font-size: 20px;">UserName</th>
                <th class="mail" style="font-size: 20px;">Email</th>
                <th class="dbo" style="font-size: 20px;">DOB</th>
                <th class="role" style="font-size: 20px;">Role</th>
                </tr>
                <?php
                $sn=($page*15)-14;
                if (mysqli_num_rows($result2) > 0) {
                
                while($data = mysqli_fetch_assoc($result2)) {
                ?>
                <tr class="row1">
                <td class="sno" ><?php echo $sn; ?></td>
                <td class="uname"><?php echo $data['name']; ?></td>
                <td class="mail"><?php echo $data['email']; ?></td>
                <td class="dob"><?php echo $data['dob']; ?></td>
                <td class="role"><?php echo $data['role']; ?> </td>
                <tr>
                <?php
                $sn++;}} else { ?>
                <tr>
                <td colspan="8">No data found</td>
                </tr>
                <?php } ?>
                </table>


                <div style="margin-bottom: 2em;margin-top: 1.5em">
                    <a href="update.php" id="update" style="font-size: 1.3em; margin-right: 5em">Update Database</a>
                    <?php
                    echo "<a style='font-size:1.2em' href='view.php?page=1'>First Page</a>"."&nbsp;&nbsp;&nbsp;&nbsp;";
                    $i=$page;
                    $li = $i-1;
                    $ui = $i+1;

                    if($li==0){
                        echo "<a style='font-size:1.2em' href='view.php?page=1'>1</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=2'>2</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=3'>3</a>"."&nbsp;&nbsp;&nbsp;&nbsp;";
                    }else if($ui>$total_pages){
                        echo "<a style='font-size:1.2em' href='view.php?page=".($li-1)."'>".($li-1)."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=".$li."'>".$li."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=".$i."'>".$i."</a>"."&nbsp;&nbsp;&nbsp;&nbsp;";
                    }else{
                        echo "<a style='font-size:1.2em' href='view.php?page=".$li."'>".$li."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=".$i."'>".$i."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='view.php?page=".$ui."'>".$ui."</a>"."&nbsp;&nbsp;&nbsp;&nbsp;";
                    }

                    echo "<a style='font-size:1.2em' href='view.php?page=".$total_pages."'>Last Page</a>";
                    ?>
                    <a href="logout.php" style="font-size: 1.3em; margin-left: 5em;">Log Out</a>
                </div>
             
            </div>
        </form>
        <script >

var test = "<?php echo $role ?>";
console.log(test);  
if(test == "user"){
const element = document.getElementById('update');
element.style.visibility = 'hidden';
}
</script>

    </body>
</html>