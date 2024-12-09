<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit;
    }

    require_once "../database/config.php";
    $title = "Amdin | Add Category";
    ob_start();
?>

    <link rel="stylesheet" href="style/dashboard.css">
    <main>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="field-input">
                <label for="">Category Name</label>
                <input type="text" name="name" id="">
            </div>
            <div class="field-input">
                <label for="">Category Description</label>
                <textarea name="description" id=""></textarea>
            </div>
            <div class="field-input">
                <label for="">Category Image</label>
                <input type="file" name="image" id="">
            </div>

            <div class="submit">
                <input type="submit" value="Add" name="add">
            </div>
        </form>
    </main>

<?php
    $content = ob_get_clean();
    include_once "layout/app.php";
    include_once "layout/master.php";
?>