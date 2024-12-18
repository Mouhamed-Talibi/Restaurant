<?php
    require '../database/config.php';
    require_once "include/admin_session.php";

    // categories query:
    $stmt = mysqli_prepare($connect, "SELECT * FROM products");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // layout needs
    $title = "Admin | Products";
    $stylePath = "style/products.css";
    ob_start();
?>

    <!-- content -->
    <div class="products-container">
            <!-- displaying products -->
            <?php
                while($product = mysqli_fetch_assoc($result)){
                    ?>
                        <div class="product">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name']?>">
                            <h3><?= $product['name']?></h3>
                            <p><?= $product['description']?></p>
                            <span class="price"><?= $product['price']?> Mad</span>
                            <div class="links">
                                <a href="edit_product.php?id=<?= $product['id']?>">Edit</a>
                                <a href="delete_product.php?id=<?= $product['id']?>">Delete</a>
                            </div>
                        </div>
                    <?php
                }
            ?>
    </div>

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>