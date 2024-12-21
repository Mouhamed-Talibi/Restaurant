<?php
    require "../database/config.php";
    require "include/admin_session.php";

    // check if id is valid
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $validId = $_GET['id'];

        // select current category
        $stmt = mysqli_prepare($connect, 'SELECT * FROM categories WHERE id=?');
        mysqli_stmt_bind_param($stmt, "i", $validId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $category = mysqli_fetch_assoc($result);
        
        // Check if category exists
        if (!$category) {
            echo "<div class='alert alert-danger'>Category not found.</div>";
            exit;
        }

        // Delete category
        $error = '';
        if (isset($_POST['delete'])) {
            $query = mysqli_prepare($connect, "DELETE FROM categories WHERE id=?");
            mysqli_stmt_bind_param($query, "i", $validId);
            if (mysqli_stmt_execute($query)) {
                // delete the category image from the folder it was stored
                if (file_exists($category['image'])) {
                    unlink($category['image']);
                } else {
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Image Not Found On The Server !! 
                        </div>
                    ";
                }
                $error .= "
                    <div class='alert alert-success' role='alert'>
                        Category Deleted Successfully ✔
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'categories.php';
                        }, 500); // 500 milliseconds = 0.5 second
                    </script>
                ";
            } else {
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Category Not Deleted !! 
                    </div>
                ";
            }
        }
    } else {
        // Invalid ID or ID not set
        echo "<div class='alert alert-danger'>Invalid category ID.</div>";
        exit;
    }

    $title = "Admin | Delete Category";
    $stylePath = "style/delete_category.css";
    ob_start();
?>

    <div class="confirmation">
        <!-- errors section -->
        <?php if (!empty($error)) { echo $error; } ?>

        <h3>Are You Sure You Want To Delete This Category?</h3>
        <div class="category">
            <!-- Retrieving categories -->
            <div class="card" style="width: 300px; margin:auto;">
                <img 
                    src="<?= !empty($category['image']) ? $category['image'] : 'placeholder.jpg' ?>" 
                    class="card-img-top" 
                    alt="Category Image"
                    style="height: 200px; object-fit: cover"
                >
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                        <?= htmlspecialchars($category['name']) ?>
                    </h5>
                    <p class="card-text"><?= htmlspecialchars($category['description']) ?></p>
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
                    <a href="categories.php" class="btn btn-success">
                        No, Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>
