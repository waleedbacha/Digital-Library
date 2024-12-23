<?php 
include('dashboard_header.php');
require_once('config.php');

// Initialize variables with empty values
$isbn = $book_title = $category = $author = $publisher = $edition = $volume = $year = $description = $cover_image = '';

// Fetch the existing book details
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $query = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = pg_query($conn, $query);

    if ($result && pg_num_rows($result) > 0) {
        $book = pg_fetch_assoc($result);
        $id = $book['book_id'];
        $isbn = $book['isbn'];
        $book_title = $book['book_title'];
        $category = $book['category'];
        $author = $book['author'];
        $publisher = $book['publisher'];
        $edition = $book['edition'];
        $volume = $book['volume'];
        $year = $book['year'];
        $description = $book['description'];
        $cover_image = $book['cover'];
    }
}

// Handle form submission for updating book details
if(isset($_POST['submit'])){
    $isbn = $_POST['isbn'] ?? ''; 
    $book_title = $_POST['book_title'] ?? '';
    $category = $_POST['category'] ?? '';
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $edition = $_POST['edition'] ?? '';
    $volume = $_POST['volume'] ?? '';
    $year = $_POST['year'] ?? '';
    $description = $_POST['description'] ?? '';
    $new_cover_image = $_FILES['cover_image']['name'] ?? '';

    // Update cover image if a new one is uploaded
    if (!empty($new_cover_image)) {
        $cover_target = "uploads/cover/" . basename($new_cover_image);
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_target)) {
            $cover_image = $new_cover_image; // Use the new cover image
        } else {
            echo "Error while uploading the cover image.";
        }
    }

    // Update the book details in the database
    $query = "UPDATE books SET 
        book_title = '$book_title',
        category = '$category',
        author = '$author',
        publisher = '$publisher',
        \"edition\" = '$edition',
        volume = '$volume',
        \"year\" = '$year',
        cover = '$cover_image',
        description = '$description'
        WHERE book_id = '$id'";

    $result = pg_query($conn, $query);
    if($result){
        echo "<script> alert('Book Updated'); </script>";
    }
}

// Fetch categories for the dropdown
$cat_query = "SELECT * FROM categories";
$cat_result = pg_query($conn, $cat_query);
?>
<div class="form-cont">
    <h5>Edit Book</h5>
    <form class="" method="POST" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <label>ISBN </label>
                <input type="text" class="form-control" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" readonly>
                <label>Book Title</label>
                <input type="text" class="form-control" name="book_title" value="<?php echo htmlspecialchars($book_title); ?>" placeholder="Book Title">
                <label>Category </label>
                <select class="form-control" name="category">
                    <?php
                        while($cat = pg_fetch_assoc($cat_result)){
                            $cat_name = $cat['cat_name'];
                            $selected = $category === $cat_name ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($cat_name) . "' $selected>$cat_name</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label>Author</label>
                <input type="text" class="form-control" name="author" value="<?php echo htmlspecialchars($author); ?>" placeholder="Author">
            </div>
            <div class="col-6">
                <label>Publisher</label>
                <input type="text" class="form-control" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>" placeholder="Publisher">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Edition</label>
                <input type="text" class="form-control" name="edition" value="<?php echo htmlspecialchars($edition); ?>" placeholder="Edition">
            </div>
            <div class="col-4">
                <label>Volume</label>
                <input type="text" class="form-control" name="volume" value="<?php echo htmlspecialchars($volume); ?>" placeholder="Volume">
            </div>
            <div class="col-4">
                <label>Year</label>
                <input type="text" class="form-control" name="year" value="<?php echo htmlspecialchars($year); ?>" placeholder="Year">
            </div>
        </div>
        <div class="row" style="background: #F5F8FD; padding: 20px 0 20px 0; margin: 2px;">
            <div class="col-6">    
                <label for="uploadbtn">Select Book Cover</label>
                <input type="file" name="cover_image" class="form-control">
                <?php if (!empty($cover_image)): ?>
                    <p>Current Cover:</p>
                    <img src="uploads/cover/<?php echo htmlspecialchars($cover_image); ?>" alt="Cover Image" style="width: 100px; height: auto; max-height: 200px; object-fit: cover; margin-top: 10px;">
                    
                    <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>Description</label>
                <textarea rows="5" name="description" class="form-control" placeholder="Description"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
        </div>
        <input type="submit" class="btn bg-primary mt-2 mb-5 btn-block" name="submit" value="Update Book">
    </form>
</div>
</div>

<?php 
include('dashboard_footer.php');
?>
