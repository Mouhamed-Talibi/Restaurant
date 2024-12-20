<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> <?php echo $title ?> </title>

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Parkinsans:wght@300..800&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
        <!-- icon link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <!-- style link -->
        <link rel="stylesheet" href="<?php echo $stylePath; ?>">
    </head>

    <body>
        <!-- Navbar -->
        <header>
            <nav class="navbar">
                <div class="brand">
                    <b>Your Restaurant</b>
                </div>
                <div class="links">
                    <a href="dashboard.php">Home</a>
                    <a href="#">Orders</a>
                    <a href="categories.php">Categoires</a>
                    <a href="products.php">Products</a>
                    <a href="add_Category.php">Add Category</a>
                    <a href="add_product.php">Add Product</a>
                    <a href="logout.php" class="logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                </div>
            </nav>
        </header>

        <!-- content -->
        <?php echo $content; ?>

        <!-- footer -->
        <footer>
            <div class="main">
                <p>Developed By <a href="">Mouhamed Talibi</a> | Copyrights &copy; | All Rights Reserverd</p>
                <div class="search-bar">
                    <input type="text" placeholder="Search orders, users, or products...">
                    <button>Search</button>
                </div>
                <div class="links">
                    <a href="dashboard.php">Home</a>
                    <a href="products.php">Products</a>
                    <a href="categories.php">Categories</a>
                </div>
            </div>
        </footer>
    </body>
</html>
