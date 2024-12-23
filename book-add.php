<?php 
include('dashboard_header.php');
require_once('config.php');

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
    $book_file = $_FILES['file']['name'] ?? '';

    // Book File (PDF, DOC)
    $file_target = "uploads/books/" . basename($book_file);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_target)) {
        echo "Book file uploaded successfully.";
    } else {
        echo "Error while uploading book file.";
    }

    // Cover Image - Now handled by upload_cover.php
    $cover_image = $_POST['cover_image'] ?? ''; // This should be set by the JavaScript and AJAX call

    // PostgreSQL query for inserting book data
    $query = "INSERT INTO books (isbn, book_title, category, author, publisher, edition, volume, year, cover, file, description) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
    
    $result = pg_query_params($conn, $query, [
        $isbn, $book_title, $category, $author, $publisher, $edition, $volume, $year, $cover_image, $book_file, $description
    ]); // Replaced mysqli_query with pg_query_params

    if($result){
        echo "<script> alert('Book Added'); </script>";
    }
}

$cat_query = "SELECT * FROM categories";
$cat_result = pg_query($conn, $cat_query); 
$cat = pg_fetch_assoc($cat_result); 
?>
<div class="form-cont">
    <h5>Add Book</h5>
    <form class="" method="POST" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <label>ISBN </label>
                <input type="text" class="form-control" name="isbn" placeholder="ISBN">
                <label>Book Title</label>
                <input type="text" class="form-control" name="book_title" placeholder="Book Title">
                <label>Category </label>
                <select class="form-control" name="category">
                    <?php
                        while($cat = pg_fetch_assoc($cat_result)){
                            $cat_name = $cat['cat_name'];
                            echo "<option value='" . htmlspecialchars($cat_name) . "'>" . htmlspecialchars($cat_name) . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label>Author</label>
                <input type="text" class="form-control" name="author" placeholder="Author">
            </div>
            <div class="col-6">
                <label>Publisher</label>
                <input type="text" class="form-control" name="publisher" placeholder="Publisher">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Edition</label>
                <input type="text" class="form-control" name="edition" placeholder="Edition">
            </div>
            <div class="col-4">
                <label>Volume</label>
                <input type="text" class="form-control" name="volume" placeholder="Volume">
            </div>
            <div class="col-4">
                <label>Year</label>
                <input type="text" class="form-control" name="year" placeholder="Year">
            </div>
        </div>
        <div class="row" style="background: #F5F8FD; padding: 20px 0 20px 0 ;margin: 2px;">
            <div class="col-3">    
                <label for="uploadbtn">Select Book</label>
                <input type="file" name="file" class="form-control" id="pdfInput" accept="application/pdf" onchange="updateInputLabel()">
            </div>
            
            <div class="col-3">
                <button type="button" class="btn btn-secondary mt-4 m-auto" id="extractCoverButton">Extract Cover</button>
            </div>
            <div class="col-3">
                <label for="uploadbtn">Select Cover</label>
                <input type="hidden" name="cover_image" id="coverImageHidden">
                <img id="coverImagePreview" src="#" alt="Cover Image Preview" style="display: none; width: 100px; height: auto;max-height: 200px; object-fit: cover; margin-top: 10px;">
            </div>
            <div class="col-3">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>Description</label>
                <textarea rows="5" name="description" class="form-control" placeholder="Description"></textarea>
            </div>
        </div>
        
        <input type="submit" class="btn bg-primary mt-2 mb-5 btn-block" name="submit" value="Add Book">
    </form>
</div>
</div>

<style>
</style>
<?php 
include('dashboard_footer.php');
?>
<script>
document.getElementById('extractCoverButton').addEventListener('click', function() {
    var pdfInput = document.getElementById('pdfInput').files[0];
    if (pdfInput) {
        var fileReader = new FileReader();
        fileReader.onload = function(e) {
            var typedarray = new Uint8Array(e.target.result);
            
            pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    var viewport = page.getViewport({ scale: 1.5 });
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    
                    page.render({ canvasContext: context, viewport: viewport }).promise.then(function() {
                        canvas.toBlob(function(blob) {
                            // Generate a unique file name
                            var uniqueName = 'cover_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9) + '.jpg';
                            
                            var formData = new FormData();
                            formData.append('coverImage', blob, uniqueName);
                            
                            // Send the cover image to the server
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'upload_cover.php', true);
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Set the file name as the value
                                    document.getElementById('coverImageHidden').value = xhr.responseText;
                                    
                                    var imgElement = document.getElementById('coverImagePreview');
                                    imgElement.src = URL.createObjectURL(blob); // Set image preview
                                    imgElement.style.display = 'block'; // Show the image element
                                } else {
                                    alert('An error occurred while uploading the cover image.');
                                }
                            };
                            xhr.send(formData);
                        });
                    });
                });
            });
        };
        fileReader.readAsArrayBuffer(pdfInput);
    } else {
        alert('Please select a PDF file.');
    }
});
</script>
