<?php
require_once('config.php');

if(isset($_GET['book']) && isset($_GET['book_id'])) {
    $isbn = pg_escape_string($conn, $_GET['book']);
    $book_id = pg_escape_string($conn, $_GET['book_id']);

    // Query to fetch book details
    $query = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = pg_query($conn, $query);

    // Check if a book was found
    if ($result && pg_num_rows($result) > 0) {
        $data = pg_fetch_assoc($result);

        $isbn = $data['isbn'];
        $book_title = $data['book_title'];
        $category = $data['category'];
        $sub_category = $data['sub_category'];
        $author = $data['author'];
        $publisher = $data['publisher'];
        $edition = $data['edition'];
        $volume = $data['volume'];
        $year = $data['year'];
        $cover = $data['cover'];
        $file = $data['file'];
        $description = $data['description'];
    } else {
        $error_msg = "Book not found.";
    }
} else {
    $error_msg = "Book is More available";
}

// Close the database connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <nav class="navbar justify-content-between">
        <a class="navbar-brand" href="index.php"><span class="text-white"><img src="images/logo.png" width="30%"></span></a>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link main-btn" href="login.php">Login <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </nav>
</div>
<div class="container mt-5">
    <?php if (isset($error_msg)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
    <?php else: ?>
        <div class="book-details">
            <div class="row justify-content-between">
                <div class="col-lg-4">
                    <div class="book-cover">
                        <img src="<?php echo 'uploads/cover/' . htmlspecialchars($cover); ?>" alt="Book Cover">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="book-desc">
                        <h3 class="mb-2"><?php echo $book_title; ?></h3>
                        <p><?php echo $description; ?></p>
                        <p>Author: <?php echo $author; ?></p>
                        <p>Publisher: <?php echo $publisher; ?></p>
                        <p>Subject: <?php echo $category; ?></p>
                    </div>
                    <div class="book-action">
                        <button id="downloadBtn" class="btn downloadBtn main-btn" onclick="window.open('uploads/books/<?php echo htmlspecialchars($file); ?>', '_blank');">Download</button>
                        <a class="btn main-btn" href="#pdf-viewer">Read</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div id="pdf-viewer">
        <div id="loading-message" style="display: none;">Loading PDF...</div>
        <div id="pdf-pages"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var url = 'uploads/books/<?php echo htmlspecialchars($file); ?>';

    document.getElementById('loading-message').style.display = 'block';

    pdfjsLib.getDocument(url).promise.then(function (pdf) {
        var numPages = pdf.numPages;
        var pdfPagesContainer = document.getElementById('pdf-pages');

        for (var pageNumber = 1; pageNumber <= numPages; pageNumber++) {
            pdf.getPage(pageNumber).then(function (page) {
                var scale = 1.5;
                var viewport = page.getViewport({ scale: scale });

                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                pdfPagesContainer.appendChild(canvas);

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(function () {
                    if (pdfPagesContainer.children.length === numPages) {
                        document.getElementById('loading-message').style.display = 'none';
                    }
                });
            });
        }
    });
});

function updateDownloadButton() {
    const downloadEnabled = localStorage.getItem("downloadEnabled") === "true";
    document.getElementById("downloadBtn").disabled = !downloadEnabled;
}

window.onload = function() {
    updateDownloadButton();
};
</script>
</body>
</html>
