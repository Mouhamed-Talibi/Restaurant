<?php
    require_once "include/admin_session.php";
    require_once "../database/config.php";

    // admin infos
    if(isset($_SESSION['admin_id'])){
        $query  = mysqli_prepare($connect, "SELECT * FROM admins WHERE id=?");
        mysqli_stmt_bind_param($query, "i", $_SESSION['admin_id']);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $admin  = mysqli_fetch_assoc($result);
    }

    // totale products :
    $productsQuery = mysqli_prepare($connect, "SELECT id FROM products");
    mysqli_stmt_execute($productsQuery);
    $result = mysqli_stmt_get_result($productsQuery);
    $products_rows = mysqli_num_rows($result);

    // totale categories :
    $categoriesQuery = mysqli_prepare($connect, "SELECT id FROM categories");
    mysqli_stmt_execute($categoriesQuery);
    $result = mysqli_stmt_get_result($categoriesQuery);
    $categories_rows = mysqli_num_rows($result);

    // set title
    $title = "Admin | Dashboard";
    $stylePath = "style/dashboard.css";
    ob_start();
?>

    <!-- content -->
    <main>
        <div class="message">
            <h2>Welcome Back, <span><?= $admin['username']?></span>!</h2>
            <br>
            <p>
                Would you like to: 
                <a href="add_Category.php">Add Category</a>
                <a href="add_Product.php">Add Product</a>
                <a href="orders.php">View Orders</a>
            </p>
        </div>

        <div class="statics">
            <div class="card">
                <div class="card-title">Totale Products :</div>
                <div class="card-description"><span><?= $products_rows?></span> Product</div>
            </div>
            <div class="card">
                <div class="card-title">Totale Categories:</div>
                <div class="card-description"><span><?= $categories_rows ?></span> category</div>
            </div>
            <div class="card">
                <div class="card-title">Totale Orders :</div>
                <div class="card-description"><span>67</span> Order</div>
            </div>
            <div class="card">
                <div class="card-title">Cancled Orders :</div>
                <div class="card-description"><span>68</span> Orders</div>
            </div>
        </div>
    </main> 

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>