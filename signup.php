<?php
    require_once('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="shrink-to-fit=no, width= device-width, initial-scale= 1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/header.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            position: relative;
            margin: 0;
            padding: 0;
            height: 100vh; 
            z-index: 1;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            z-index: -1;
        }

        .signin-form-cont {
            max-width: 600px;
            height: auto;
            margin: 10px auto;
            background: rgba(69, 50, 240, 0.8);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 0 10px #000;
        }

        .signin-form-cont img {
            margin: auto;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .signin-form-cont h3 {
            color: #fff;
            text-align: center;
            margin-top: 10px;
        }

        .signin-form-cont form {
            padding: 20px;
        }

        .signin-form-cont form .form-group {
            display: flex;
            align-items: center;
            margin: 10px 0;
            
        }

        .signin-form-cont form .form-group label {
            color: #fff;
            flex: 0 0 150px;
            margin-right: 10px;
            text-align: right;
        }

        .signin-form-cont form .form-group input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .signin-form-cont form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .signin-form-cont form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="signin-form-cont">
        <img src="images/logo.png" width="40%">

        <h3>Signup here</h3>

        <form method="POST" action="">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" placeholder="Full Name" name="fullname" id="fullname" class="form-control" required="required">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Email" name="email" id="email" class="form-control" required="required">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" name="username" id="username" class="form-control" required="required">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" name="password" id="password" class="form-control" required="required">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" class="form-control" required="required">
            </div>

            <input type="submit" value="Signup" name="signup" class="form-control">
        </form>
    </div>

    <?php
    if (isset($_POST['signup'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

       
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match');</script>";
        } else {
            
            $fullname = pg_escape_string($conn, $fullname);
            $email = pg_escape_string($conn, $email);
            $username = pg_escape_string($conn, $username);
            $password_hash = password_hash($password, PASSWORD_BCRYPT); 

            $query = "INSERT INTO users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password_hash')";
            $result = pg_query($conn, $query);

            if ($result) {
                echo "<script>alert('Registration successful!');</script>";
                header("Location: login.php");
            } else {
                echo "<script>alert('Error during registration.');</script>";
            }
        }
    }
    ?>
</body>
</html>
