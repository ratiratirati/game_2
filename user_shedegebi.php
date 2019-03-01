<html>
<head>
    <title>მოთმამაშეების შედეგები</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/user_shedegebi.css">
    <link rel="stylesheet" type="text/css" href="css/dropdown.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <script src="js/dropdown.js"></script>
</head>
<body>
<?php
include ('server.php');
include ('proces.php');

if(empty($_SESSION['username'])){
    header ('location:index.php');
}

if(isset($_GET['logout'])){
    session_destroy ();
    unset($_SESSION['username']);
    header ('location:index.php');
}
?>
<div class="header">
    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn"><?php echo $_SESSION['username'];?></button>
        <div id="myDropdown" class="dropdown-content">
            <a href="admin.php">უკან დაბრუნება</a>
            <a href="admin.php?logout='1'">გამოსვლა</a>
        </div>
    </div>
</div>
<table>
    <tr>
        <th>სახელი</th>
        <th>ამოუვიდა</th>
        <th>საათი</th>
        <th>წელი / თვე / რიცხვი</th>
        <th>წაშლა</th>
    </tr>
    <?php
    $sql = "SELECT * FROM shedegebi";
    $result = mysqli_query ($con,$sql);
    if(mysqli_num_rows ($result)){
        while ($row = mysqli_fetch_assoc ($result)){
            echo '<tr><td>'.$row['saxeli'].'</td><td>'.$row['amouvida'].'</td><td>'.$row['saati'].'</td><td>'.$row['dge'].'</td><td>
            <form method="post" action="user_shedegebi.php">
            <input type="hidden" value="'.$row['id'].'" name="deleteusergameid">
            <button id="delgame" name="deletegame">წაშლა</button>
            </form>
            </td></tr>';
        }
    }
    ?>
</table>
</body>
</html>