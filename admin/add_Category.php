<?php
    require "../database/config.php";
    require "include/admin_session.php";

    $error = "";
    // add category Logic :
    if(isset($_POST['add_category'])){
        if(
            isset($_POST['category_name'], $_POST['category_description'], $_POST['category_icon'], $_FILES['category_image']) 
            && !empty($_POST['category_name']) && !empty($_POST['category_description'])&& !empty($_POST['category_icon']) && !empty($_FILES['category_image'])
        ) {
            // valid & sanitize data :
            $category_name        = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);
            $category_description = filter_var($_POST['category_description'], FILTER_SANITIZE_STRING);
            $category_icon        = filter_var($_POST['category_icon'], FILTER_SANITIZE_STRING);

            // handling the image :
            $allowed_types  = ['image/jpeg', 'image/png', 'image/gif'];
            $category_image = $_FILES['category_image'];
            $imageName      =  uniqid() . "_" . basename($category_image['name']);
            $imageTmpName   = $_FILES['category_image']['tmp_name'];
            $imageFolder    = "uploads/categories/";
            $imageUpload    = $imageFolder. $imageName;

            // check ir category already exists :
            $query = mysqli_prepare($connect, "SELECT * FROM categories WHERE name=? OR image=?");
            mysqli_stmt_bind_param($query, "ss", $category_name, $imageUpload);
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            if(mysqli_num_rows($result) > 0){
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Category Already Exists !!
                    </div>
                ";
            }
            else{
                // if valid image
                if(in_array($category_image['type'],  $allowed_types)){
                    if(move_uploaded_file($imageTmpName, $imageUpload)){
                        $stmt = mysqli_prepare(
                            $connect,
                            "INSERT INTO categories(name, description, icon, image) VALUES (?, ?, ?, ?)"
                        );
                        mysqli_stmt_bind_param($stmt, "ssss", $category_name, $category_description, $category_icon, $imageUpload);
                        if (mysqli_stmt_execute($stmt)) {
                            $error .= "
                                <div class='alert alert-success' role='alert'>
                                    New Category Added ✔
                                </div>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = 'categories.php';
                                    }, 500); // 500 milliseconds = 0.5 second
                                </script>
                            ";
                        } 
                        else {
                            $error .= "
                                <div class='alert alert-danger' role='alert'>
                                    Category Not Added!
                                </div>
                            ";
                        }
                    } 
                    else {
                        $error .= "
                            <div class='alert alert-danger' role='alert'>
                                Problem with uploading image!
                            </div>
                        ";
                    }
                }
                else{
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Image Type Not Supported !!
                        </div>
                    ";
                }
            }
        }
        else{
            $error .= "
                <div class='alert alert-danger' role='alert'>
                    All Fields Are Required!
                </div>
            ";
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
            <input type="text" name="category_name" id="">
        </div>
        <div class="field-input">
            <label for="">Category Description</label>
            <textarea name="category_description" id=""></textarea>
        </div>
        <div class="field-input">
            <label for="">Category Icon</label>
            <input type="text" name="category_icon" id="" placeholder="Example: fa-solid fa-house">
        </div>
        <div class="field-input">
            <label for="">Category Image</label>
            <input type="file" name="category_image" id="">
        </div>
        <!-- submit -->
        <input type="submit" value="Add category" name="add_category">
    </form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>