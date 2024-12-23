<?php
  require_once('config.php');
  session_start();

  if(isset($_SESSION['username'])){
      $username = $_SESSION['username'];
      // Replace MySQL with PostgreSQL connection and query execution
      $query = "SELECT * FROM users WHERE username = '$username'";
      $result = pg_query($conn, $query);  // Changed from mysqli_query to pg_query

      $data = pg_fetch_assoc($result);  // Changed from mysqli_fetch_assoc to pg_fetch_assoc
      $name = $data['name'];
      $phone = $data['phone'];
  } else {
      header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Emananon Institute Digital Library - Dashboard</title>
    <style>
        /* Your existing styles */
    </style>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <style>::-webkit-scrollbar {
                                  width: 8px;
                                }
                                /* Track */
                                ::-webkit-scrollbar-track {
                                  background: #f1f1f1; 
                                }
                                 
                                /* Handle */
                                ::-webkit-scrollbar-thumb {
                                  background: #888; 
                                }
                                
                                /* Handle on hover */
                                ::-webkit-scrollbar-thumb:hover {
                                  background: #555; 
                                } @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");:root{--header-height: 3rem;--nav-width: 68px;--first-color: #4723D9;--first-color-light: #AFA5D9;--white-color: #F7F6FB;--body-font: 'Nunito', sans-serif;--normal-font-size: 1rem;--z-fixed: 100}*,::before,::after{box-sizing: border-box}body{position: relative;margin: var(--header-height) 0 0 0;padding: 0 1rem;font-family: var(--body-font);font-size: var(--normal-font-size);transition: .5s}a{text-decoration: none}.header{width: 100%;height: var(--header-height);position: fixed;top: 0;left: 0;display: flex;align-items: center;justify-content: space-between;padding: 0 1rem;background-color: var(--white-color);z-index: var(--z-fixed);transition: .5s}.header_toggle{color: var(--first-color);font-size: 1.5rem;cursor: pointer}.header_img{width: 35px;height: 35px;display: flex;justify-content: center;border-radius: 50%;overflow: hidden}.header_img img{width: 40px}.l-navbar{position: fixed;top: 0;left: -30%;width: var(--nav-width);height: 100vh;background-color: var(--first-color);padding: .5rem 1rem 0 0;transition: .5s;z-index: var(--z-fixed)}.nav{height: 100%;display: flex;flex-direction: column;justify-content: space-between;overflow: hidden}.nav_logo, .nav_link{display: grid;grid-template-columns: max-content max-content;align-items: center;column-gap: 1rem;padding: .5rem 0 .5rem 1.5rem}.nav_logo{margin-bottom: 2rem}.nav_logo-icon{font-size: 1.25rem;color: var(--white-color)}.nav_logo-name{color: var(--white-color);font-weight: 700}.nav_link{position: relative;color: var(--first-color-light);margin-bottom: 1.5rem;transition: .3s}.nav_link:hover{color: var(--white-color)}.nav_icon{font-size: 1.25rem}.show{left: 0}.body-pd{padding-left: calc(var(--nav-width) + 1rem)}.active{color: var(--white-color)}.active::before{content: '';position: absolute;left: 0;width: 2px;height: 32px;background-color: var(--white-color)}.height-100{height:100vh}@media screen and (min-width: 768px){body{margin: calc(var(--header-height) + 1rem) 0 0 0;padding-left: calc(var(--nav-width) + 2rem)}.header{height: calc(var(--header-height) + 1rem);padding: 0 2rem 0 calc(var(--nav-width) + 2rem)}.header_img{width: 40px;height: 40px}.header_img img{width: 45px}.l-navbar{left: 0;padding: 1rem 1rem 0 0}.show{width: calc(var(--nav-width) + 156px)}.body-pd{padding-left: calc(var(--nav-width) + 188px)}}
                                
                                a:hover{
                                    text-decoration: none;
                                }
                                .header-menu {
      display: flex;
      flex-wrap: wrap;
      background: transparent;
      border-radius: 5px;
      text-align: center;
      padding: 10px;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }
    .header-menu img {
      border-radius: 50px;
      width: 35px;
      height: 35px;
      object-fit: cover;
      box-shadow: 0 3px 5px #ccc;
      margin: 2px;
    }
    .header-menu div {
      margin: 2px;
    }
                                </style>
    
</head>
<body className="snippet-body">
<body id="body-pd">
    <div class="header mb-5" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="dropdown" style="width: 200px;">
            <div class="header-menu dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div>
                    <i class="fa fa-user mr-3" style="font-size: 18px;"></i><?php echo "$name"; ?>
                </div>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="#" class="nav_logo"> 
                    <img src="images/logo.png" width="20%">
                </a>
                <div class="nav_list">
                    <a class="nav_link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                        <i class='fas fa-tachometer-alt nav_icon'></i> 
                        <span class="nav_name">Dashboard</span>
                    </a>
                    <a class="nav_link <?php echo (basename($_SERVER['PHP_SELF']) == 'book-add.php') ? 'active' : ''; ?>" href="book-add.php">
                        <i class='fas fa-plus nav_icon'></i> 
                        <span class="nav_name">Add Book</span>
                    </a>
                    <a class="nav_link <?php echo (basename($_SERVER['PHP_SELF']) == 'book-manage.php') ? 'active' : ''; ?>" href="book-manage.php">
                        <i class='fas fa-book nav_icon'></i> 
                        <span class="nav_name">Manage Books</span>
                    </a>
                    <a class="nav_link <?php echo (basename($_SERVER['PHP_SELF']) == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
                        <i class="fas fa-list nav_icon"></i>
                        <span class="nav_name">Categories</span>
                    </a>
                    <a class="nav_link <?php echo (basename($_SERVER['PHP_SELF']) == 'users-manage.php') ? 'active' : ''; ?>" href="users-manage.php">
                        <i class='fas fa-users nav_icon'></i> 
                        <span class="nav_name">Manage Users</span>
                    </a>
                </div>  
            </div> 
            <a href="logout.php" class="nav_link"> 
                <i class='fas fa-sign-out-alt nav_icon'></i> 
                <span class="nav_name">Sign Out</span> 
            </a>
        </nav>
    </div>

    <div class="height-100">
    <!-- Rest of your content here -->
    </div>
</body>
</html>



























    