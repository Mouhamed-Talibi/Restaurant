<?php
    session_start();
    require_once "../database/config.php";
    $title = "Admin | Dashboard";

    // check for session  : 
    if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])){
        header('Location: index.php');
        exit();
    }

    ob_start();
?>
    <link rel="stylesheet" href="style/dashboard.css">
    <div class="container">
        <!-- welcome message to current admin -->
        <?php
            $adminId = $_SESSION['admin_id'];
            $stmt = mysqli_prepare($connect, "SELECT * FROM admins WHERE id=?");
            mysqli_stmt_bind_param($stmt, "i", $adminId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            // fetch admin data : 
            $admin = mysqli_fetch_array($result, MYSQLI_ASSOC);
        ?>

        <div class="welcome">
            <h2>Hello <?=  $admin['username']; ?></h2>
            <p>Happy To See You Again</p>
        </div>

        <div class="easy-access">
            <p>Would You Like To : </p>
            <a href="">Take A Look At All Products</a>
            <a href="">Add A Category</a>
        </div>
    </div>

<?php
    $content = ob_get_clean();
    include_once "layout/app.php";
    include_once "layout/master.php";
?>

