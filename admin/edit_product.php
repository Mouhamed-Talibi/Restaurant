<?php
    require_once "../database/config.php";
    require_once "include/admin_session.php";

    $error = '';
    // check for valid id :
    if(isset($_GET['id']) && intval($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        $validId = $_GET['id'];
        // select current product data :
        $curr_product_stmt = mysqli_prepare($connect, "SELECT * FROM products WHERE id=?");
        mysqli_stmt_bind_param($curr_product_stmt, "i", $validId);
        mysqli_stmt_execute($curr_product_stmt);
        $result = mysqli_stmt_get_result($curr_product_stmt);
        $currentProduct = mysqli_fetch_assoc($result);
    }
    else{
        $error .= "
            <div class='alert alert-danger' role='alert'>
                The Product Id Not Valid !! 
            </div>
        ";
    }

    // update product :
    if(isset($_POST['update'])){
        if(!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['category'])){
            // sanitize inputs :
            $productName        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $productDescription = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            is_numeric($_POST['price']) 
                ? $productPrice = $_POST['price'] 
                : $error .= "<div class='alert alert-danger' role='alert'> The Price Not Valid !!</div> ";
            is_numeric($_POST['category']) 
                ? $productCategory = $_POST['category'] 
                : $error .= "<div class='alert alert-danger' role='alert'> The Category Not Valid !!</div> ";

            // checking for image 
            if(isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                // delete old image and handle the uploaded one :
                if(file_exists($currentProduct['image'])){
                    $deleted = unlink($currentProduct['image']);
                    $deleted 
                        ? $error .= "<div class='alert alert-primary' role='alert'> Old imgage deleted ✔ </div> "
                        : $error .= "<div class='alert alert-danger' role='alert'> Old image not deleted ✖ </div> "
                    ;
                }
                else{
                    $error .= "
                        <div class='alert alert-danger' role='alert'> 
                            Image Not Found !! 
                        </div> 
                    ";
                }

                // handle the new uploaded image :
                $allowed_types  = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                $productImage   = $_FILES['image'];
                $imageName      =  uniqid() . "_" . basename($productImage['name']);
                $imageTmpName   = $productImage['tmp_name'];
                $imageFolder    = "uploads/products/";
                $imageUpload    = $imageFolder. $imageName;
                // update product 
                if(in_array($productImage['type'], $allowed_types)){
                    if(move_uploaded_file($imageTmpName, $imageUpload)){
                        $stmt = mysqli_prepare(
                            $connect,
                            "UPDATE products SET name=?,
                                                        description=?,
                                                        price=?,
                                                        categoryId=?,
                                                        image=?
                                                    WHERE 
                                                        id=?"
                        );
                        mysqli_stmt_bind_param(
                            $stmt, "ssdisi",
                            $productName, $productDescription, $productPrice, $productCategory, $imageUpload, $validId
                        );
                        if(mysqli_stmt_execute($stmt)){
                            $error .= "
                                <div class='alert alert-success' role='alert'>
                                    Product Updated Successfully ✔
                                </div>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = 'products.php';
                                    }, 500); // 500 milliseconds = 0.5 second
                                </script>
                            ";
                        } else{
                            $error .= "
                                <div class='alert alert-danger' role='alert'>
                                    Product Not Updated ✖
                                </div>
                            ";
                        }
                    } else{
                        $error .= "
                            <div class='alert alert-danger' role='alert'>
                                A problem With Uplaoding The Image !! 
                            </div>
                        ";
                    }
                } else{
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Image Type Not Supported ! 
                        </div>
                    ";
                }
            } else{
                // update without image : 
                $stmt = mysqli_prepare(
                    $connect,
                    "UPDATE products SET name=?,
                                                description=?,
                                                price=?,
                                                categoryId=?
                                            WHERE 
                                                id=?"
                );
                mysqli_stmt_bind_param(
                    $stmt, "ssdii",
                    $productName, $productDescription, $productPrice, $productCategory, $validId
                );
                if(mysqli_stmt_execute($stmt)){
                    $error .= "
                        <div class='alert alert-success' role='alert'>
                            Product Updated Successfully ✔
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = 'products.php';
                            }, 500); // 500 milliseconds = 0.5 second
                        </script>
                    ";
                } else{
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Product Not Updated ✖
                        </div>
                    ";
                }
            }
        } else{
            $error .= "
                <div class='alert alert-danger' role='alert'> 
                    All Fields Are Required !! 
                </div> 
            ";
        }
    }

    // html vars
    $title = "Admin | Editing Product";
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
            <label for="category">Product Category</label>
            <select name="category" id="category">
                <!-- select stored category -->
                <?php
                    $categoriesQuery = mysqli_query($connect, "SELECT id, name FROM categories");
                    while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                        // Check if this category matches the current product's category
                        $selected = ($category['id'] == $currentProduct['categoryId']) ? 'selected' : '';
                        ?>
                            <option value="<?= $category['id'] ?>" <?= $selected ?>> <?= $category['name'] ?> </option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="field-input">
            <label for="">Product Image</label>
            <input type="file" name="image" id="">
        </div>
        <!-- submit -->
        <input type="submit" value="Update category" name="update">
    </form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>