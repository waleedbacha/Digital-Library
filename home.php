<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Navbar */
        .navbar {
            background: #003566;
            color: #fff;
            padding: 1rem 0;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .nav-links .btn {
            margin-left: 10px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            color: #fff;
            background-color: #0077b6;
        }

        .navbar .nav-links .btn-signup {
            background-color: #00b4d8;
        }

        .navbar .nav-links .btn:hover {
            background-color: #0096c7;
        }

        /* Hero Section */
        .hero {
            background: url('./images/Library-Management.jpg') no-repeat center center/cover;
            height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 0 1rem;
        }

        .hero-content {
            max-width: 600px;
            background: rgba(0, 0, 0, 0.6);
            padding: 2rem;
            border-radius: 10px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero .btn-cta {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            background-color: #00b4d8;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .hero .btn-cta:hover {
            background-color: #0077b6;
        }

        /* Footer */
        .footer {
            background: #003566;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }

        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">Digital Library</div>
            <div class="nav-links">
            <a class="btn" href="login.php">Login <span class="sr-only"></span></a>

            <a class="btn" href="Signup.php">SignUp <span class="sr-only"></span></a>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <h1>Welcome to the Digital Library</h1>
            <p>
                Explore a world of knowledge and resources at your fingertips. 
                Our library offers thousands of eBooks, research papers, and learning materials 
                to help you excel in your studies and beyond.
            </p>
            <a href="signup.php" class="btn btn-cta">Get Started</a>
        </div>
    </header>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Digital Library. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
