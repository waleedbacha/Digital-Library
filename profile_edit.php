<?php
    require_once('config.php');
    include('dashboard_header.php');
   
    if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];

        // Query for PostgreSQL
        $query = "SELECT * FROM users WHERE username = $1";
        $result = pg_query_params($conn, $query, [$username]);

        if ($result) {
            $data = pg_fetch_assoc($result);
            $name = $data['name'];
            $phone = $data['phone'];
            $password = $data['password'];
            $role = $data['role'];
        } else {
            echo "Error fetching user data: " . pg_last_error($conn);
            exit;
        }
	}else{
		header("Location: login.php");
	}

    if(isset($_POST['update'])){
        $up_name = $_POST['up_name'];
        $up_phone = $_POST['up_phone'];

        // Query for PostgreSQL
        $update = "UPDATE users SET name = $1, phone = $2 WHERE username = $3";
        $update_result = pg_query_params($conn, $update, [$up_name, $up_phone, $username]);

        if($update_result){
           echo "<script> alert('Profile Updated');window.location.href='profile.php'</script>";
        } else {
            echo "Error updating profile: " . pg_last_error($conn);
        }
    }
   
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8" />
    <meta name="viewport"  content="shrink-to-fit=no, width= device-width, initial-scale= 1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">

    <title>Profile - iShalmany</title>

</head>
<body>
    <!-- Page content-->
    <div class="height-100">
        
    <div class="profile-cont">
      
        <div class="profile-info">
        <table>
            <tbody>
                <form method="POST" action="">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><input type="text" name="up_name" class="form-control text-right" value="<?php echo "$name"; ?>"></td>
                </tr>
                <tr>
                    <td><strong>Username:</strong></td>
                    <td><input type="text" name="up_username" class="form-control text-right" value="<?php echo "$username"; ?>" disabled="disabled"></td>
                </tr>
               
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td><input type="text" name="up_phone" class="form-control text-right" value="<?php echo "$phone"; ?>"></td>
                </tr>
                
            </tbody>
        </table>

                  
        </div>
            <button type="submit" name="update" class="btn btn-block" style="border-radius: 0px; background: #d2d5d5;height: 60px;font-size: 22px;">Update</button> 
        </form>
    </div>
    </div>
    
    <style>
        .profile-cont{
            width: 800px;
            height: auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 10px #ccc;
            margin: 150px auto;
            overflow: hidden;
        }    

        .profile-info{
            padding: 30px 10px 30px 10px ;
            
        }



        /* Basic table styling */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 20px;
}


/* Basic table styling */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 20px;
}

/* Table header styles */
th {
    text-align: left;
}

/* Table data styles */
td {
    padding: 10px;
    text-align: center; /* Center-align text in both columns */
}

/* Align first column (Name) to the left */
td:first-child {
    text-align: left;
}

/* Align second column (Value) to the right */
td:nth-child(2) {
    text-align: right;
}

@media screen and (max-width: 400px )
{
    .profile-cont{
        max-width: 100%;
        
    }
    
}
    </style>
<?php include('dashboard_footer.php'); ?>
