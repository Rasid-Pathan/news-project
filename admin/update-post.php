<?php include "header.php"; 
    include "config.php";
    if ($_SESSION['user_role'] == 0 ) {
        $post_id = $_GET['id'];

            $sql2 = "SELECT author FROM post WHERE post.post_id = {$post_id}";

            $result2 = mysqli_query($conn,$sql2) or die("Query Failed.");
            $row2 = mysqli_fetch_assoc($result2);
            if ($row2['author'] != $_SESSION['user_id']) {
                header("Location: {$hostname}/admin/post.php");
            }
    }
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <?php 

            $post_id = $_GET['id'];

            $sql = "SELECT * FROM post 
            LEFT JOIN category on post.category = category.category_id 
            LEFT JOIN user on post.author = user.user_id 
            WHERE post.post_id = {$post_id}";

            $result = mysqli_query($conn,$sql) or die("Query Failed.");
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
        ?>
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $row['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <?php 
                    $sql1 = "SELECT * FROM category";

                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                    if(mysqli_num_rows($result1)>0){
                        while($row1 = mysqli_fetch_assoc($result1)){
                            if ($row1["category_id"] == $row["category"]) {
                                echo "<option value='{$row1["category_id"]}' selected>{$row1['category_name']}</option>";
                            } else {
                                echo "<option value='{$row1["category_id"]}'>{$row1['category_name']}</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img src="upload/<?php echo $row['post_img']; ?>" height="170px" width="170px" style="object-fit: contain;">
                <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>" height="170px" width="170px" style="object-fit: contain;">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php 
                        }
                    }else{
                        echo "Result not found";
                    }
                  ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
