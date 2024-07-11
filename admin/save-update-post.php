<?php 
    include "config.php";

    if(empty($_FILES['new-image']['name'])){
        $file_name = $_POST['old-image'];
    }else {
        $error = array();

        $file_name = time().$_FILES['new-image']['name'];
        $file_size = $_FILES['new-image']['size'];
        $file_tmp = $_FILES['new-image']['tmp_name'];
        $file_type = $_FILES['new-image']['type'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $extension = array("jpeg","jpg","png");

        if(in_array($file_ext,$extension) === false){
            $error[] = "This extension file not allowed, Please choose JPEG, JPG or PNG file.";
        }

        if ($file_size > 2097152) {
            $error[] = "File size must be 2MB or lower.";
        }

        if (empty($error) == true) {
            move_uploaded_file($file_tmp,"upload/".$file_name);
            
            // Fetch existing user data
            $query = "SELECT * FROM post WHERE post_id={$_POST["post_id"]}";
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
            }
        }else{
            $i=0;
            for ($i=0; $i <count($error) ; $i++) { 
                echo $error["$i"];
            }
            die();
        }
    }
    // Fetch existing user data
    $query = "SELECT * FROM post WHERE post_id={$_POST["post_id"]}";
    $result2 = mysqli_query($conn, $query);
    if($result2) {
        $data = mysqli_fetch_assoc($result2);
    }

    $sql = "UPDATE category Set post = post-1 where category_id={$data['category']};";
    $sql .= "UPDATE post set title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='{$file_name}'where post_id={$_POST["post_id"]};";
    $sql .= "UPDATE category SET post = post+1 where category_id={$_POST['category']};";
    $result1 = mysqli_multi_query($conn,$sql);

    if($result1){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo "Query Failed";
    }
?>