<?php
    require_once "../database/config.php";
    require_once "include/admin_session.php";

    $error = '';
    if (isset($_POST['add_product'])) {
        if (
            isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_FILES['image']) &&
            !empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_FILES['image'])
        ) {
            // Sanitize inputs
            $productName        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $productDescription = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $productPrice       = floatval($_POST['price']);
            $productCategory    = intval($_POST['category']);

            // Handling image
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $productImage  = $_FILES['image'];
            $imageName     = uniqid() . "_" . basename($productImage['name']);
            $imageTmpName  = $productImage['tmp_name'];
            $imageFolder   = "uploads/products/";
            $imageUpload   = $imageFolder . $imageName;

            // Check if product already exists
            $query  = mysqli_prepare($connect, "SELECT name, categoryId, image FROM products WHERE name=? AND categoryId=? AND image=?");
            mysqli_stmt_bind_param($query, "sis", $productName, $productCategory, $imageUpload);
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            if (mysqli_num_rows($result) > 0) {
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        This product Already Exists !! 
                    </div>
                ";
            } 
            else {
                // If valid image
                if (in_array($productImage['type'], $allowed_types)) {
                    if (move_uploaded_file($imageTmpName, $imageUpload)) {
                        $stmt = mysqli_prepare(
                            $connect,
                            "INSERT INTO products(name, description, price, categoryId, image) VALUES (?, ?, ?, ?, ?)"
                        );
                        mysqli_stmt_bind_param($stmt, "ssdis", $productName, $productDescription, $productPrice, $productCategory, $imageUpload);
                        if (mysqli_stmt_execute($stmt)) {
                            // successful adding
                            $error .= "
                                <div class='alert alert-success' role='alert'>
                                    New Product Added ✔
                                </div>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = 'products.php';
                                    }, 500); 
                                </script>
                            ";
                        } 
                        else {
                            $error .= "
                                <div class='alert alert-danger' role='alert'>
                                    Product Not Added!
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
                else {
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Image Type Or Empty Image Not Accepted!!
                        </div>
                    ";
                }
            }
        } 
        else {
            $error .= "
                <div class='alert alert-danger' role='alert'>
                    All Fields Required !!
                </div>
            ";
        }
    }

    // HTML vars
    $title = "Admin | Adding Product";
    $stylePath = "style/addCategory.css";
    ob_start();
?>

<form action="" method="POST" enctype="multipart/form-data">
    <!-- Errors section -->
    <?php if (!empty($error)) { echo $error; } ?>

    <h1>Add Your Products</h1>
    <div class="field-input">
        <label for="">Product Name</label>
        <input type="text" name="name" id="">
    </div>
    <div class="field-input">
        <label for="">Product Description</label>
        <textarea name="description" id=""></textarea>
    </div>
    <div class="field-input">
        <label for="">Product Price</label>
        <input type="text" name="price" id="" placeholder="Example: 55 or 45.67">
    </div>
    <div class="field-input">
        <label for="">Product Category</label>
        <select name="category" id="">
            <option value="">Select Category</option>
            <!-- Getting available categories -->
            <?php
                $categoriesQuery = mysqli_query($connect, "SELECT id, name FROM categories;");
                if (!$categoriesQuery) {
                    die("Error retrieving categories: " . mysqli_error($connect));
                }
                while ($category = mysqli_fetch_assoc($categoriesQuery)) {
                    ?>
                        <option value="<?= htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div class="field-input">
        <label for="image">Product Image</label>
        <input type="file" name="image" id="image">
    </div>
    <input type="submit" value="Add Product" name="add_product">
</form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>
