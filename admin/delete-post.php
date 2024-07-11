<?php 
    include "config.php";

    $post_id = $_GET['id'];
    $cat_id = $_GET['catid'];

    // Fetch existing user data
    $query = "SELECT * FROM post WHERE post_id={$post_id}";
    $result = mysqli_query($conn, $query);
    if($result) {
        $data = mysqli_fetch_assoc($result);
    }

    // Delete old photo if a new one is uploaded
    if (!empty($data['post_img'])) {
        $old_photo_path = "./upload/". $data['post_img'];
        if (file_exists($old_photo_path)) {
            unlink($old_photo_path);
        }
        else{
            echo "Error!!";
            die();
        }
    }

    $sql = "DELETE FROM post where post_id={$post_id};";
    $sql .= "UPDATE category Set post = post-1 WHERE category_id={$cat_id}; ";

    if(mysqli_multi_query($conn,$sql)){
        header("Location: {$hostname}/admin/post.php"); 
    }else{
        echo "Query Failed";
    }
?>