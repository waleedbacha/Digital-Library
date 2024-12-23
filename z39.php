<form id="bookForm">
    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn">
    <button type="button" onclick="fetchBookDetails()">Search</button>
    
    <label for="title">Title:</label>
    <input type="text" id="title" name="title">
    
    <label for="author">Author:</label>
    <input type="text" id="author" name="author">
    
    <label for="publisher">Publisher:</label>
    <input type="text" id="publisher" name="publisher">
    
    <label for="year">Year:</label>
    <input type="text" id="year" name="year">
    
    <input type="submit" value="Submit">
</form>

<script>
function fetchBookDetails() {
    var isbn = document.getElementById("isbn").value;

    if (isbn) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_book_details.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var bookData = JSON.parse(xhr.responseText);
                    
                    // Check if the response contains an error
                    if (bookData.error) {
                        alert(bookData.error);
                    } else {
                        document.getElementById("title").value = bookData.title || '';
                        document.getElementById("author").value = bookData.author || '';
                        document.getElementById("publisher").value = bookData.publisher || '';
                        document.getElementById("year").value = bookData.year || '';
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    alert("There was an error fetching the book details.");
                }
            }
        };

        xhr.send("isbn=" + encodeURIComponent(isbn));
    } else {
        alert("Please enter an ISBN.");
    }
}
</script>

<!-- fetch_book_details.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'] ?? '';

    if ($isbn) {
        // Connect to PostgreSQL database
        $host = 'your_host';
        $dbname = 'your_database';
        $user = 'your_username';
        $password = 'your_password';

        $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

        if (!$conn) {
            echo json_encode(['error' => 'Database connection failed.']);
            exit;
        }

        // Query to fetch book details by ISBN
        $query = 'SELECT title, author, publisher, year FROM books WHERE isbn = $1';
        $result = pg_query_params($conn, $query, [$isbn]);

        if ($result) {
            $book = pg_fetch_assoc($result);
            if ($book) {
                echo json_encode($book);
            } else {
                echo json_encode(['error' => 'No book found with the provided ISBN.']);
            }
        } else {
            echo json_encode(['error' => 'Query execution failed.']);
        }

        // Close the database connection
        pg_close($conn);
    } else {
        echo json_encode(['error' => 'ISBN is required.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
