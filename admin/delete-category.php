<?php
include "config.php";

if(!$_SESSION['user_role'] == 1){
    header("Location: {$hostname}/admin/post.php");
}

if(!$_SESSION['user_role'] == 1){
    header("Location: {$hostname}/admin/post.php");
}
$cat_id = $_GET['id'];

$sql = "DELETE From category where category_id = '{$cat_id}'";
if (mysqli_query($conn,$sql)) {
    header("LOCATION: {$hostname}/admin/category.php");
}else{
    echo "<p style='color: red';text-align: center; margin: 10px 0px;'>Can\'t Delete The User Record</p>";
}
mysqli_close($conn);
?>