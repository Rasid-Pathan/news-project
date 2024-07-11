<?php 
    include "config.php";

    if(!$_SESSION['user_role'] == 1){
    header("Location: {$hostname}/admin/post.php");
    }
    
    if(empty($_FILES['logo']['name'])){
        $file_name = $_POST['old_logo'];
    }else {
        $error = array();

        $file_name = time().$_FILES['logo']['name'];
        $file_size = $_FILES['logo']['size'];
        $file_tmp = $_FILES['logo']['tmp_name'];
        $file_type = $_FILES['logo']['type'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $extension = array("jpeg","jpg","png");

        if(in_array($file_ext,$extension) === false){
            $error[] = "This extension file not allowed, Please choose JPEG, JPG or PNG file.";
        }

        if ($file_size > 2097152) {
            $error[] = "File size must be 2MB or lower.";
        }

        if (empty($error) == true) {
            move_uploaded_file($file_tmp,"images/".$file_name);
            
            // Fetch existing user data
            $query = "SELECT * FROM settings";
            $result = mysqli_query($conn, $query);
            if($result) {
                $data = mysqli_fetch_assoc($result);
            }

            // Delete old photo if a new one is uploaded
            if (!empty($data['logo'])) {
                $old_photo_path = "./images/". $data['logo'];
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }
        }else{
            print_r($errors);
            die();
        }
    }

    $sql = "UPDATE settings Set websitename = '{$_POST["website_name"]}', logo = '{$file_name}', footerdesc = '{$_POST["footer_desc"]}';";
    $result1 = mysqli_query($conn,$sql);

    if($result1){
        header("Location: {$hostname}/admin/setting.php");
    }else{
        echo "Query Failed";
    }
?>