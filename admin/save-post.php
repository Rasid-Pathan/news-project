<?php 
    include "config.php";
    session_start();
    if(isset($_FILES['fileToUpload'])){
        $error = array();

        $file_name = time().$_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $extension = array("jpeg","jpg","png");

        if(!in_array($file_ext,$extension)) {
            $errors[] = "This extension file is not allowed. Please choose JPEG, JPG, or PNG file.";
        }

        if ($file_size > 2097152) {
            $error[] = "File size must be 2MB or lower.";
        }

        if (empty($error) == true) {
            move_uploaded_file($file_tmp,"upload/".$file_name);
        }else{
            $i=0;
            for ($i=0; $i <count($error) ; $i++) { 
                echo $error["$i"];
            }
            die();
        }
    }
    
    $title = mysqli_real_escape_string($conn,$_POST['post_title']);
    $description = mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $sql = "INSERT into post (title,description,category,post_date,author,post_img) values('{$title}','{$description}',{$category} ,'{$date}',{$author},'{$file_name}');";
    $sql .= "UPDATE category SET post = post + 1 where category_id = {$category}";
    echo "$sql";
    if (mysqli_multi_query($conn,$sql)) {
        header("location: {$hostname}/admin/post.php");
    }else{
        echo "<div class='alert alert-danger'>Query Failed.</div>";
    }
?>