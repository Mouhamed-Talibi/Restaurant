<?php
    namespace models;
    use models\Database;

    class Admin extends Database{

        // register method :
        public function register($username, $email, $password){
            $error = '';
            if(!empty($username) && !empty($email) && !empty($password)){
                // trim username, validate email, hash pass
                $username = trim($username);
                $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
                // check if admin already exists : 
                $stmt = static::database()->prepare('SELECT * FROM admins(username, email, password) WHERE email=?');
                $stmt->execute([$valid_email]);
                $result = $stmt->fetch();
                if(count($result)){
                    $error = "Email Already Exists, Try New One !!";
                }else{
                    // register :
                    $stmt = static::database()->prepare('INSERT INTO admins VALUES(?,?,?)');
                    $stmt->execute([$username, $valid_email, $hashed_pass]);
                    return $stmt;
                }
            }
            else{
                $error = "Username, Email And Password Are Required !";
            }
            return $error;
        }

        // login method :

    }