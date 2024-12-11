<?php
    require_once "../database/config.php";
    $error = '';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST['login'])){
            // check  email, password
            if( isset($_POST['email'], $_POST['password']) 
                && !empty($_POST['email']) && !empty($_POST['password']))
            {
                // set vars : 
                $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                // check if admin exists : 
                $stmt = mysqli_prepare($connect, "SELECT * FROM admins WHERE email=?");
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $admin = mysqli_stmt_get_result($stmt);
                if($admin && $admin = mysqli_fetch_assoc($admin)){
                    // verify password : 
                    if(password_verify($password, $admin['password'])){
                        // start a session : 
                        session_start();
                        $_SESSION['admin_logged_in'] = True;
                        $_SESSION['admin_id']    = $admin['id'];
                        $_SESSION['admin_email'] = $admin['email'];
                        // redirect to dahsboard : 
                        header('Location: dashboard.php');
                        exit();
                    }
                    else{
                        $error .= "
                                <div class='alert alert-danger' role='alert'>
                                    Password Not Correct !.
                                </div>";
                    }
                }
                else{
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            No Admin Found With That Email !.
                        </div>
                    ";
                }
            }
            else{
                $error .= "
                <div class='alert alert-danger' role='alert'>
                All Fields Are Required !
                </div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Admin | Login </title>

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Parkinsans:wght@300..800&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
        <!-- icon link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <!-- style -->
        <link rel="stylesheet" href="style/main.css">
    </head>

    <body>
        <div class="container">
            <!-- errors section -->
            <?php
                if(!empty($error)){ echo $error ;}
            ?>

            <!-- title -->
            <div class="title">
                <h2>Admin Login</h2>
            </div>
            <!-- form -->
            <form action="" method="POST">
                <div class="field-input">
                    <label for="">Email</label>
                    <input type="email" name="email" id="" placeholder="example: hello@gmail.com">
                </div>
                <div class="field-input">
                    <label for="">Password</label>
                    <input type="password" name="password" id="" placeholder="example: ujh7GT#90.co">
                </div>
                <!-- form submit -->
                <div class="submit">
                    <input type="submit" value="Login" name="login">
                </div>
            </form>
            <!-- container footer -->
            <div class="footer">
                <small>
                    Don't have Account ? 
                    <a href="register.php">Register</a>
                </small>
            </div>
        </div>
    </body>
</html>
