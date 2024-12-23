<?php
include('dashboard_header.php');

if (!isset($_GET['user_id'])) {
    echo "No user ID provided.";
    exit;
}

// Ensure a valid PostgreSQL connection exists
if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$id = $_GET['user_id'];

// Query to fetch user data securely
$query = "SELECT * FROM users WHERE user_id = $1";
$result = pg_query_params($conn, $query, [$id]);

if ($result && pg_num_rows($result) > 0) {
    $data = pg_fetch_assoc($result);
    $name = htmlspecialchars($data['name']);
    $phone = htmlspecialchars($data['phone']);
    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
} else {
    echo "User not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user inputs (add more validation rules as necessary)
    if (empty($name) || empty($phone) || empty($username) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Query to update user securely
    $query = "UPDATE users SET name = $1, phone = $2, username = $3, password = $4 WHERE user_id = $5";
    $result = pg_query_params($conn, $query, [$name, $phone, $username, $password, $id]);

    if ($result) {
        echo "<script>alert('User updated successfully!'); window.location.href='users-manage.php';</script>";
    } else {
        echo "Error updating user: " . pg_last_error($conn);
    }
}
?>

<div class="form-cont" style="margin-top: 140px; max-width: 600px;">
    <h5>Edit User Info</h5>
    <form method="POST" action="">
        <input type="text" class="form-control m-1" value="<?php echo $name; ?>" name="name" required />
        <input type="text" class="form-control m-1" value="<?php echo $phone; ?>" name="phone" required />
        <input type="text" class="form-control m-1" value="<?php echo $username; ?>" name="username" required />
        <input type="password" class="form-control m-1" value="<?php echo $password; ?>" name="password" required />
        <input type="submit" name="update_user" class="btn main-btn btn-block m-1" value="Update User">
    </form>
</div>
