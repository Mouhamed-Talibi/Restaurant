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
        <input type="submit" value="Update category" name="update_category">
    </form>

<?php
    $content = ob_get_clean();
    require "layout/app.php";
?>