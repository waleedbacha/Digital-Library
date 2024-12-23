<?php
require_once('config.php');

// Check if the delete action is triggered
if (isset($_GET['delete_id'])) {
    // Get the ID of the book to be deleted
    $delete_id = pg_escape_string($conn, $_GET['delete_id']);

    // Fetch the record to get the file and cover image paths
    $query = "SELECT cover, file FROM books WHERE book_id = '$delete_id'";
    $result = pg_query($conn, $query);

    if ($result && pg_num_rows($result) > 0) {
        $data = pg_fetch_assoc($result);

        // Paths to the cover image and file
        $cover_path = 'uploads/cover/' . $data['cover'];
        $file_path = 'uploads/files/' . $data['file'];

        // Delete the cover image if it exists
        if (!empty($data['cover']) && file_exists($cover_path)) {
            if (unlink($cover_path)) {
                echo "Cover image deleted successfully.";
            } else {
                echo "Error deleting cover image.";
            }
        }

        // Delete the file if it exists
        if (!empty($data['file']) && file_exists($file_path)) {
            if (unlink($file_path)) {
                echo "Book file deleted successfully.";
            } else {
                echo "Error deleting book file.";
            }
        }

        // Delete the record from the database
        $delete_query = "DELETE FROM books WHERE book_id = '$delete_id'";
        if (pg_query($conn, $delete_query)) {
            echo "<script> alert('Record deleted successfully'); </script>";
            header("Location: book-manage.php");
            exit(); // Make sure to exit after redirecting
        } else {
            echo "Error deleting record: " . pg_last_error($conn);
        }
    } else {
        echo "Record not found.";
    }
} else {
    echo "No delete ID provided.";
}
?>
