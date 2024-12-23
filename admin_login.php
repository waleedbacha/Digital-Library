<?php
    require_once('config.php');
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="shrink-to-fit=no, width= device-width, initial-scale= 1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
    </style>

</head>

<body>
    
    <div class="signin-form-cont">
        <img src="images/logo.png" width="40%">

        <h3>Login</h3>
       
        <form method="POST" action="">
            <label class="label">Username</label>
            <input type="text" placeholder="Username" name="username" id="username" class="form-control" required="required">
            <label class="label">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" class="form-control" required="required">
            <input type="submit" value="Signin" name="login" class="form-control">
        </form>
    </div>

    <?php
    
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $username = pg_escape_string($conn, $username);
        $password = pg_escape_string($conn, $password);

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = pg_query($conn, $query);

        if(pg_num_rows($result) > 0){
            session_start();
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        }
        else{
            echo "<script> alert('User not found'); </script>";
        }
    }
    ?>
</body>
</html>
