<?php
include "config.php";    
if(!$_SESSION['user_role'] == 1){
    header("Location: {$hostname}/admin/post.php");
}
$user_id = $_GET['id'];

$sql = "DELETE From user where user_id = '{$user_id}'";
if (mysqli_query($conn,$sql)) {
    header("LOCATION: {$hostname}/admin/users.php");
}else{
    echo "<p style='color: red';text-align: center; margin: 10px 0px;'>Can\'t Delete The User Record</p>";
}
mysqli_close($conn);
?>