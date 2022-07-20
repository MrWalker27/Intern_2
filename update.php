<?php
session_start();
$role = $_SESSION['role'];
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

    $nmu = $_SESSION['nmu'];
    
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
        <link rel="stylesheet" href="update1.css"/>
        <title>Update</title>
    </head>
    <body>
        
        <form method="post" >
            <div class="container2" id="cont">
                <div class="info2">
            <h1 id="Heading" >Current User: <?php echo $_SESSION['name']?></h1>
                <h1 id="Heading" style="margin-top: 0em; margin-bottom: 1em">Permission level: <?php echo $_SESSION['role']?></h1>
                <!-- Number of rows: <select name="select">
                <option  selected value="15">15</option>
                  <option value="30">30</option>
                  <option value="50">50</option>
                </select> -->
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
                // $start_from=($page-1)*($num_per_page);
                $start_from=($page-1)*15;
                
                $sql = "SELECT * FROM `data` WHERE role = 'user'";
                $result = mysqli_query($conn, $sql);

                $total_records = mysqli_num_rows($result);
                    $total_pages = ceil($total_records/$num_per_page);
                    ?><div style="position:absolute; margin-top:19em;"></div><?php
                   
                    $sql2 = "SELECT * FROM `data` WHERE role = 'user' limit $start_from,$num_per_page";
                $result2 = mysqli_query($conn, $sql2);
                ?>

                <table border ="1">
                <tr>
                <th class="sno" style="font-size: 20px;">Sno</th>
                <th class="uname" style="font-size: 20px;">UserName</th>
                <th class="mail2" style="font-size: 20px;">Email</th>
                <th class="dbo" style="font-size: 20px;">DOB</th>
                <th class="role2" style="font-size: 20px;">Role</th>
                <th class="role" style="font-size: 20px;" colspan = "2">MODIFY</th>
                </tr>
                <?php
                $sn=($page*15)-14;
                // $sn=($page*($num_per_page))-($num_per_page-1);
                if (mysqli_num_rows($result2) > 0) {
                
                while($data = mysqli_fetch_assoc($result2)) {
                ?>
                <tr class="row1">
                <td class="sno" ><?php echo $sn; ?></td>
                <td class="uname"><?php echo $data['name']; ?></td>
                <td class="mail"><?php echo $data['email']; ?></td>
                <td class="dob"><?php echo $data['dob']; ?></td>
                <td class="role"><?php echo $data['role']; ?> </td>
                <td class="role"><a href="edit.php?nm=<?php echo $data['name']; ?>" >Edit</a> </td>
                <td class="role"><a href="delete.php?nm=<?php echo $data['name']; ?>">Delete </a></td>
                <tr>
                <?php
                $sn++;}} else { ?>
                <tr>
                <td colspan="8">No data found</td>
                </tr>
                <?php } ?>
                </table>

                <div style="margin-bottom: 2em; margin-top: 1.5em">
                <?php
                    echo "<a style='font-size:1.2em; margin-left:15em;' href='update.php?page=1'>First Page</a>"."&nbsp;&nbsp;&nbsp;";
                    $i=$page;
                    $li = $i-1;
                    $ui = $i+1;

                    if($li==0){
                        echo "<a style='font-size:1.2em' href='update.php?page=1'>1</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=2'>2</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=3'>3</a>"."&nbsp;&nbsp;&nbsp;";
                    }else if($ui>$total_pages){
                        echo "<a style='font-size:1.2em' href='update.php?page=".($li-1)."'>".($li-1)."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=".$li."'>".$li."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=".$i."'>".$i."</a>"."&nbsp;&nbsp;&nbsp;";
                    }else{
                        echo "<a style='font-size:1.2em' href='update.php?page=".$li."'>".$li."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=".$i."'>".$i."</a>"."&nbsp;&nbsp;&nbsp;";
                        echo "<a style='font-size:1.2em' href='update.php?page=".$ui."'>".$ui."</a>"."&nbsp;&nbsp;&nbsp;";
                    }

                    echo "<a style='font-size:1.2em' href='update.php?page=".$total_pages."'>Last Page</a>";
                    ?>
                    <a href="logout.php" style="font-size: 1.3em; margin-left: 9em;">Log Out</a>
                </div>
                </div>
        </form>
        </body>
</html>