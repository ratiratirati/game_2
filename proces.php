<?php
$msg = '';

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


if(isset($_POST['register'])){
    $username = mysqli_real_escape_string ($con,$_POST['username']);
    $password = mysqli_real_escape_string ($con,$_POST['password']);
    $password_2 = $_POST['password_2'];
    $ip = get_client_ip();
    if(empty($username)){
        array_push ($errors,'მომხმარებლის ველი ცარიელია');
    }

    if(empty($password)){
        array_push ($errors,'პაროლის ველი ცარიელია');
    }

    if($password != $password_2){
        array_push ($errors,'პაროლერბი არ ემთხვევა');
    }

    if(count ($errors) ==  0 ){
        $password = md5 ($password);
        $sql = "INSERT INTO users (ip,username,password) VALUES ('$ip','$username','$password')";
        if(mysqli_query ($con,$sql)){
            $msg = 'რეგისტრაცია წარმატებულია';
        }
    }
}

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string ($con,$_POST['username']);
    $password = mysqli_real_escape_string ($con,$_POST['password']);

    if(empty($username)){
        array_push ($errors,'მომხმარებლის ველი ცარიელია');
    }

    if(empty($password)){
        array_push ($errors,'პაროლის ველი ცარიელია');
    }

    if(count ($errors) ==  0 ){
        $password = md5 ($password);
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
        $result = mysqli_query ($con,$sql);
        if(mysqli_num_rows ($result)){
            $row = mysqli_fetch_assoc ($result);
           $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
           if($username == 'admin'){
               header ('location:admin.php');
           }else{
               header ('location:home.php');
           }
        }else{
            array_push ($errors,'მომხმარებლის სახელი ან პაროლი არასწორია');
        }
    }
}

date_default_timezone_set ('Asia/tbilisi');
$t = date('h:i:s');
$d = date('Y-m-d');
if(isset($_POST['pas'])){
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $rand = rand(1,2);
    if($rand == 1){
        $msg ='სიმართლე';
    }
    if($rand == 2){
        $msg ='მოქმედება';
    }
    $sql = "INSERT INTO shedegebi (saxeli,user_id,amouvida,saati,dge) VALUES ('$username','$user_id','$msg','$t','$d')";
    mysqli_query ($con,$sql);
    echo "<style>#txt{display: none;}</style>";
}


if(isset($_POST['deletegame'])){
    $sql = "DELETE FROM shedegebi WHERE id='".$_POST['deleteusergameid']."'";
    mysqli_query ($con,$sql);
}
?>