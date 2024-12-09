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

    $title = "Your Restaurant | Admin Login";
    ob_start();
?>

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

<?php
    $content = ob_get_clean();
    include "layout/app.php";
?>
