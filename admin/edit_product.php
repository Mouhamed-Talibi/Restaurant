<?php
    require "../database/config.php";
    require "include/admin_session.php";

    // specified category :
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $productQuery = mysqli_prepare($connect, "SELECT * FROM products WHERE id=?");
    mysqli_stmt_bind_param($productQuery, "i", $id);
    mysqli_stmt_execute($productQuery);
    $result = mysqli_stmt_get_result($productQuery);
    $currentProduct = mysqli_fetch_assoc($result);

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
            if(mysqli_close($connect)){
                header('Location: categories.php');
                exit();
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
            <label for="">Product Name</label>
            <input type="text" name="name" id="" value="<?= $currentProduct['name']?>">
        </div>
        <div class="field-input">
            <label for="">Product Description</label>
            <textarea name="description" id=""><?= $currentProduct['description']?></textarea>
        </div>
        <div class="field-input">
            <label for="">Product Price</label>
            <input type="text" name="price" id="" placeholder="Example: 55 or 70.55" value="<?= $currentProduct['price']?>">
        </div>
        <div class="field-input">
            <label for="">Product Category</label>
            <select name="category" id="">
                <option value="<?= $currentProduct['id']?>"> Salads</option>
                <!-- select categories -->
                <?php
                    $categoriesQuery = mysqli_query($connect, "SELECT id, name FROM categories");
                    while($category = mysqli_fetch_assoc($categoriesQuery)){
                        ?>
                            <option value="<?= $category['id']?>"><?= $category['name']?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <!-- submit -->
        <input type="submit" value="Update category" name="update_category">
    </form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>