<?php
    require_once('config.php');
    include('dashboard_header.php');
  
    if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = pg_query($conn, $query);

    $data = pg_fetch_assoc($result);
        $name = $data['name'];
        $phone = $data['phone'];
        $password = $data['password'];
        $role = $data['role'];
        
	}else{
		header("Location: login.php");
	}

    //function to make the password encoded
    function maskText($text, $visibleChars = 1) {
        $maskedText = str_repeat('*', strlen($text) - $visibleChars) . substr($text, -$visibleChars);
        return $maskedText;
    }

    $maskpass = maskText($password);
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
            <h5>YOUR INFORMATION</h5>
        <table>
            <tbody>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo "$name"; ?></td>
                </tr>
                <tr>
                    <td><strong>Username:</strong></td>
                    <td><?php echo "$username"; ?></td>
                </tr>
                
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td><?php echo "$phone"; ?></td>
                </tr>
                <tr>
                    <td><strong>Password:</strong></td>
                    <td><?php echo "$maskpass"; ?></td>
                </tr>
            </tbody>
        </table>

                  
        </div>
        <a href="profile_edit.php"><button class="btn btn-block" style="border-radius: 0px; background: #f1f1f1;height: 60px;font-size: 22px;vertical-align:bottom;">Edit</button></a> 

    </div>
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

      .profile-cont .profile-info{
        justify-content: center;
      }
        .profile-cont h5{
            text-align: center;
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
