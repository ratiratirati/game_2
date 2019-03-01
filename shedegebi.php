<html>
<head>
    <title>მომხმარებლის გვერდი</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/shedegebi.css">
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
            <a href="home.php">უკან დაბრუნება</a>
            <a href="game.php">თამაში</a>
            <a href="home.php?logout='1'">გამოსვლა</a>
        </div>
    </div>
</div>
<table>
    <tr>
        <th>სახელი</th>
        <th>ამოუვიდა</th>
        <th>საათი</th>
        <th>წელი / თვე / რიცხვი</th>
    </tr>
    <?php
    $sql = "SELECT * FROM shedegebi";
    $result = mysqli_query ($con,$sql);
    if(mysqli_num_rows ($result)){
        while ($row = mysqli_fetch_assoc ($result)){
            echo '<tr><td>'.$row['saxeli'].'</td><td>'.$row['amouvida'].'</td><td>'.$row['saati'].'</td><td>'.$row['dge'].'</td></tr>';
        }
    }
    ?>
</table>
</body>
</html>