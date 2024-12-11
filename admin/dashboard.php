<?php
    require_once "include/admin_session.php";
    // set title
    $title = "Admin | Dashboard";
    ob_start();
?>
    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.navbar .links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>

    <!-- content -->
    <link rel="stylesheet" href="style/dashboard.css">

<?php
    $content = ob_get_clean();
    require_once "layout/app.php";
?>