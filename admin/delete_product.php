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

        if(!$currentProduct){
            $error .= "
                <div class='alert alert-danger' role='alert'>
                    No Product Found With This Id 
                </div>
            ";
        }
    }
    else{
        $error .= "
            <div class='alert alert-danger' role='alert'>
                The Product Id Not Valid !! 
            </div>
        ";
    }

    // delete product :
    if(isset($_POST['delete'])){
        $stmt = mysqli_prepare(
            $connect, 
            "DELETE FROM products WHERE id=? AND name=?"
        );
        mysqli_stmt_bind_param($stmt, "is", $validId, $currentProduct['name']);
        if(mysqli_stmt_execute($stmt)){
            $error .= "
                <div class='alert alert-primary' role='alert'>
                    Product Deleted Successfully ✔
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'products.php';
                    }, 1000); 
                </script>
            ";
        } else{
            $error .= "
                <div class='alert alert-danger' role='alert'>
                    Failed to delete the product. Please try again later.
                </div>
            ";
        }
    }

    $title = "Admin | Delete Product";
    $stylePath = "style/delete_category.css";
    ob_start();
?>

    <div class="confirmation">
        <!-- errors section -->
        <?php if (!empty($error)) { echo $error; } ?>

        <h3>Are You Sure You Want To Delete This Product?</h3>
        <div class="category">
            <!-- Retrieving categories -->
            <div class="card" style="width: 300px; margin:auto;">
                <img 
                    src="<?= !empty($currentProduct['image']) ? $currentProduct['image'] : 'placeholder.jpg' ?>" 
                    class="card-img-top" 
                    alt="Category Image"
                    style="height: 200px; object-fit: cover"
                >
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($currentProduct['name']) ?>
                    </h5>
                    <p class="card-text"><?= htmlspecialchars($currentProduct['description']) ?></p>
                </div>
                <div class="card-body d-flex justify-content-between">
                    <!-- Delete Form -->
                    <form action="" method="POST">
                        <!-- <input type="hidden" name="category_id" value=""> -->
                        <button type="submit" class="btn btn-danger" name="delete">
                            Yes, Delete
                        </button>
                    </form>
                    <!-- Cancel Link -->
                    <a href="products.php" class="btn btn-success">
                        No, Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
    $content = ob_get_clean();
    include_once "layout/app.php";
?>