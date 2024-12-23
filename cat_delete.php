<?php
include('config.php');

if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    $cat_id = pg_escape_string($conn, $cat_id);

    $query = "DELETE FROM categories WHERE cat_id = '$cat_id'";

    if (pg_query($conn, $query)) {
        echo "<script>alert('Category Deleted successfully!'); window.location.href='categories.php';</script>";
        exit();
    } else {
        echo "Error deleting record: ";
    }
} else {
    echo "<script>alert('No Category found'); window.location.href='categories.php';</script>";
    exit();
}

pg_close($conn);
?>
