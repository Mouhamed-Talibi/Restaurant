<?php
    session_start();

    // Check if the admin is logged in
    if (
        empty($_SESSION['admin_id']) || 
        empty($_SESSION['admin_email']) || 
        $_SESSION['admin_logged_in'] !== true
    ) {
        // Redirect to login page if not authenticated
        header('Location: index.php');
        exit();
    }

    // Regenerate session ID every 10 minutes to prevent session fixation
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 600) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
?>
