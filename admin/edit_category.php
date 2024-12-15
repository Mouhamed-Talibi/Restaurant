<?php
    require "../database/config.php";
    require "include/admin_session.php";

    // specified category :
    $id = $_GET['id'];
    $categories_query = mysqli_prepare($connect, "SELECT * FROM categories WHERE id=?");
    mysqli_stmt_bind_param($categories_query, "i", $id);
    mysqli_stmt_execute($categories_query);
    $result = mysqli_stmt_get_result($categories_query);
    $current_category = mysqli_fetch_assoc($result);

    $error = "";
    // add category Logic :
    if(isset($_POST['update_category'])){
        if(
            isset($_POST['category_name'], $_POST['category_description'], $_POST['category_icon']) 
            && !empty($_POST['category_name']) && !empty($_POST['category_description'])&& !empty($_POST['category_icon'])
        ) {
            // valid & sanitize data :
            $category_name        = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);
            $category_description = filter_var($_POST['category_description'], FILTER_SANITIZE_STRING);
            $category_icon        = filter_var($_POST['category_icon'], FILTER_SANITIZE_STRING);

            // update records :
            $stmt = mysqli_prepare($connect, "UPDATE categories SET name=?, description=?, icon=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "sssi", $category_name, $category_description, $category_icon, $id);
            if(mysqli_stmt_execute($stmt)){
                $error .= "
                    <div class='alert alert-primary' role='alert'>
                        Category Updated Sccessfully ✔
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'categories.php';
                        }, 500); // 500 milliseconds = 0.5second
                    </script>
                ";
            }
            else{
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Category Not Updated !! 
                    </div>
                ";
            }
        }
        else{
            // re-insert the old records :
            $category_stmt = mysqli_prepare($connect, "UPDATE categories SET name=?, description=?, icon=? WHERE id=?");
            mysqli_stmt_bind_param($category_stmt, "sssi", $current_category['name'], $current_category['description'], $current_category['icon'], $id);
            if(mysqli_stmt_execute($category_stmt)){
                $error .= "
                    <div class='alert alert-primary' role='alert'>
                        Category Updated Sccessfully ✔
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'categories.php';
                        }, 500); // 500 milliseconds = 0.5second
                    </script>
                ";
            }
            else{
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Category Not Updated !! 
                    </div>
                ";
            }
        }
    }

    // html vars
    $title = "Admin | Adding Category";
    $stylePath = "style/addCategory.css";
    ob_start();

?>

    <!-- content -->
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- errors section -->
        <?php       
            if(!empty($error)){ echo $error; }
        ?>

        <div class="field-input">
            <label for="">Category Name</label>
            <input type="text" name="category_name" id="" value="<?= $current_category['name']?>">
        </div>
        <div class="field-input">
            <label for="">Category Description</label>
            <textarea name="category_description" id=""><?= $current_category['description']?></textarea>
        </div>
        <div class="field-input">
            <label for="">Category Icon</label>
            <input type="text" name="category_icon" id="" placeholder="Example: fa-solid fa-house" value="<?= $current_category['icon']?>">
        </div>
        <div class="field-input">
            <label for="">Category Image</label>
            <input type="file" name="category_image" id="">
        </div>
        <!-- submit -->
        <input type="submit" value="Update category" name="update_category">
    </form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>