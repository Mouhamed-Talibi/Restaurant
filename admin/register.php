<?php
    require_once "../database/config.php";
    $error = '';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST['username'], $_POST['email'], $_POST['password']) 
            && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']))
        {
            // validation flag
            $isValid = true; 
            // set min-max chars : 
            if(strlen($_POST['username']) < 5 || strlen($_POST['username']) > 50){
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Username Must Be Between 5 And 50 Chars !
                    </div>";
                $isValid = false;
            }
            
            if(strlen($_POST['password']) < 8 || strlen($_POST['password']) > 60){
                $error .= "
                    <div class='alert alert-danger' role='alert'>
                        Password Must Be Between 8 And 60 Chars !
                    </div>";
                $isValid = false;
            }

            // Only proceed if validation passes
            if($isValid) {
                // set vars : 
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];

                // check if admin exists : 
                $stmt = mysqli_prepare($connect, "SELECT email FROM admins WHERE email=?");
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if(mysqli_fetch_assoc($result)){
                    $error .= "
                        <div class='alert alert-danger' role='alert'>
                            Email Already exists !
                        </div>";
                }
                else{
                    // register as new : 
                    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = mysqli_prepare($connect, "INSERT INTO admins(username, email, password) VALUES(?,?,?)");
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_pass);
                    $registered = mysqli_stmt_execute($stmt);
                    
                    // redirect to login page : 
                    if($registered){
                        header('Location: index.php');
                        exit();
                    }
                    else{
                        $error .= "
                            <div class='alert alert-danger' role='alert'>
                                Registration failed. Please try again.
                            </div>";
                    }
                }
            }
        }
        else{
            $error .= "
                <div class='alert alert-danger' role='alert'>
                    All Fields Are Required !
                </div>";
        }
    }

    $title = "Your Restaurant | Admin Registration";
    ob_start();
?>

    <div class="container">
        <!-- error section -->
        <?php
            if(!empty($error)){
                echo $error;
            }
        ?>

        <!-- title -->
        <div class="title">
            <h2>Admin Registration</h2>
        </div>
        <!-- form -->
        <form action="" method="POST">
            <div class="field-input">
                <label for="">Username</label>
                <input type="text" name="username" id="">
            </div>
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
                <input type="submit" value="Register">
            </div>
        </form>
        <!-- container footer -->
        <div class="footer">
            <small>
                Already Have Account ? 
                <a href="index.php">Login</a>
            </small>
        </div>
    </div>

<?php
    $content = ob_get_clean();
    include_once "layout/app.php";
?>