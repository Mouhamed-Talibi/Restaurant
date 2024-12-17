<?php
    require '../database/config.php';
    require_once "include/admin_session.php";

    // categories query:
    $stmt = mysqli_prepare($connect, "SELECT * FROM categories");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // layout needs
    $title = "Admin | Categories";
    $stylePath = "style/categories.css";
    ob_start();
?>

    <!-- content -->
    <div class="main-categories">
        <section>Food Categories</section>
        <a href="add_Category.php" class="adding-category-link"> Add New category </a>
        <div class="category">
            <!-- retreiving categories -->
            <?php
                while($category = mysqli_fetch_assoc($result)){
                    ?>
                        <div class="card" style="width: 18rem;">
                            <img src="<?php echo $category['image']?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="<?= $category['icon']?>"></i>
                                    <?= $category['name']?>
                                </h5>
                                <p class="card-text"><?= $category['description']?></p>
                            </div>
                            <div class="card-body">
                                <a href="edit_category.php?id=<?= $category['id']?>" class="card-link">Edit</a>
                                <a href="delete_category.php?id=<?= $category['id']?>" class="card-link" onclick="return confirm('You Really Want To delete This Category')">Delete</a>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>