<?php
    require_once "include/admin_session.php";
    // set title
    $title = "Admin | Dashboard";
    ob_start();
?>

    <!-- content -->
    <link rel="stylesheet" href="style/dashboard.css">
    <main>
        <div class="message">
            <h2>Welcome Back, <span>Mouhamed Talibi</span>!</h2>
            <br>
            <p>
                Would you like to: 
                <a href="add_category.php">Add Category</a>
                <a href="add_product.php">Add Product</a>
                <a href="orders.php">View Orders</a>
            </p>
        </div>

        <div class="statics">
            <div class="card">
                <div class="card-title">Total Orders:</div>
                <div class="card-description"><span>190</span> Order</div>
            </div>
            <div class="card">
                <div class="card-title">Orders Paid:</div>
                <div class="card-description"><span>178</span> Order</div>
            </div>
            <div class="card">
                <div class="card-title">Orders Canceled:</div>
                <div class="card-description"><span>67</span> Order</div>
            </div>
            <div class="card">
                <div class="card-title">Total Amount:</div>
                <div class="card-description"><span>$15,564</span></div>
            </div>
        </div>
    </main> 

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>