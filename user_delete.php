<?php
include('config.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // PostgreSQL escape using pg_escape_string
    $user_id = pg_escape_string($conn, $user_id);

    // Query for PostgreSQL
    $query = "DELETE FROM users WHERE user_id = $1";

    $result = pg_query_params($conn, $query, [$user_id]);

    if ($result) {
        echo "<script>alert('User Deleted successfully!'); window.location.href='users-manage.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . pg_last_error($conn);
    }
} else {
    echo "<script>alert('No user found'); window.location.href='users-manage.php';</script>";
    exit();
}

pg_close($conn);
?>
