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
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Admin | Registration </title>

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Parkinsans:wght@300..800&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
        <!-- icon link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <!-- style link -->
        <link rel="stylesheet" href="style/main.css">
    </head>

    <body>
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
    </body>
    </html>