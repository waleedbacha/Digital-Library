<?php
require_once('config.php');

// Retrieve the selected category from the URL
$category_filter = isset($_GET['category']) ? pg_escape_string($conn, $_GET['category']) : '';
$search_term = isset($_GET['search']) ? pg_escape_string($conn, $_GET['search']) : '';

// PSQL query based on the selected category and search term
$query = "SELECT * FROM books";
if (!empty($category_filter)) {
    $query .= " WHERE category = '$category_filter'";
}

if (!empty($search_term)) {
    $query .= (!empty($category_filter) ? " AND " : " WHERE ") . "
    (book_title ILIKE '%$search_term%' OR
    isbn ILIKE '%$search_term%' OR
    author ILIKE '%$search_term%' OR
    publisher ILIKE '%$search_term%')";
}

$result = pg_query($conn, $query);

$cat_query = "SELECT * FROM categories";
$cat_result = pg_query($conn, $cat_query);

// Query to count total books in the library
$total_books_query = "SELECT COUNT(*) as total_books FROM books";
$total_books_result = pg_query($conn, $total_books_query);
$total_books = 0;
if ($total_books_result && pg_num_rows($total_books_result) > 0) {
    $total_books_data = pg_fetch_assoc($total_books_result);
    $total_books = $total_books_data['total_books'];
}

// Array that hold books
$books_by_category = [];
$empty_msg = ""; 

if (pg_num_rows($result) > 0) {
    while ($data = pg_fetch_assoc($result)) {
        $category = $data['category'];

        $books_by_category[$category][] = $data;
    }
} else {
    $empty_msg;
}
pg_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="shrink-to-fit=no, width=device-width">

    <title>Emanon Institute | Digital Library</title>

    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .total-books {
            margin-top: 20px;
            padding: 5px;
            border: 2px solid #007BFF;
            border-radius: 8px;
            background-color: #F8F9FA;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
        }
        .thumbnail-container {
            width: 100%;
            max-width: 180px; 
            margin: 0 auto; 
            overflow: hidden;
            text-align: center;
            position: relative; 
        }
        .thumbnail-container img {
            width: 100%;
            height: 250px; 
            object-fit: cover; 
            border-radius: 5px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .thumbnail-container img:hover {
            transform: scale(1.1); 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /*  shadow for pop-up effect */
        }
        .book-desc {
            text-align: center;
            margin-top: 10px;
        }
        .book-desc h6 {
            font-size: 14px;
            font-weight: bold;
        }
        .book-desc p {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar justify-content-between">
                <a class="navbar-brand" href="index.php"><span class="text-white"><img src="images/logo.png" width="30%"></span></a>
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link main-btn" href="admin_login.php">Admin <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
            </nav>
        </div>

        <div class="search-cont">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php 
                        while($data = pg_fetch_assoc($cat_result)){
                            $cat_name = $data['cat_name'];
                            echo '<a class="dropdown-item" href="index.php?category=' . urlencode($cat_name) . '">' . $cat_name . '</a>';
                        }
                    ?>
                </div>
            </div>

            <form method="GET" action="">
                <input class="form-control" type="text" name="search" placeholder="Search By Book Name, ISBN, Author, Publisher">
            </form>
        </div>
    </header>
    <div class="container">
        <div class="row intro-cont">
            <div class="col-lg-4 wlcm">
                <h3>
                    Welcome to <br />The Emanon Institute Digital Library! 
                </h3>
                <div class="total-books">
                    Total Books in Library: <?php echo $total_books; ?>
                </div>
            </div>
            <div class="col-lg-8 intro">
                <p id="content">
                    At the Emanon Institute in New York, we are dedicated to fostering a vibrant learning environment where students can explore, discover, and grow. Our commitment to excellence in education drives us to provide the best resources for our students, both in the classroom and beyond.<br />
                    The Emanon Institute Digital Library is an extension of this mission, offering a vast collection of digital resources to support your academic journey. From scholarly articles and e-books to multimedia content and specialized databases, our digital library is designed to meet the diverse needs of our student body. Whether you're conducting research for a project, seeking additional study materials, or simply exploring new areas of interest, our digital library is here to help.<br />
                    <span id="moreText" style="display: none;">
                        Accessible anytime and anywhere, the digital library ensures that learning never has to stop. We encourage all students to take full advantage of this invaluable resource, and we are always here to assist you with any questions or guidance you may need.<br/>
                        Thank you for being a part of the Emanon Institute community. Together, we are building a brighter future through education.<br/>
                    </span>
                </p>
                <a href="javascript:void(0);" id="toggleLink" onclick="toggleContent()">Read More</a>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if (!empty($books_by_category)): ?>
            <?php foreach ($books_by_category as $category => $books): ?>
                <div class="cat-single">
                    <div class="cat-title">
                        <h4><?php echo htmlspecialchars($category); ?></h4>
                    </div>

                    <div class="row">
                        <?php
                        // Determine how many books to display
                        $books_display_limit = (!empty($category_filter) && $category_filter === $category) ? 20 : 4;
                        $books_displayed = 0;

                        foreach ($books as $book):
                            if ($books_displayed >= $books_display_limit) break; // Limit to 4 or 20 books
                        ?>
                            <div class="col-lg-3">
                                <div class="book-card">
                                    <a href="book_details.php?book=<?php echo urlencode($book['isbn']); ?>&book_id=<?php echo urlencode($book['book_id']); ?>">
                                        <div class="thumbnail-container">
                                            <img src="<?php echo 'uploads/cover/' . htmlspecialchars($book['cover']); ?>" alt="Book Cover" onerror="this.style.display='none';">
                                        </div>
                                        <div class="book-desc">
                                            <h6><?php echo htmlspecialchars(substr($book['book_title'], 0, 50) . (strlen($book['book_title']) > 50 ? '...' : ''), ENT_QUOTES, 'UTF-8'); ?></h6>
                                            <p><?php echo htmlspecialchars(substr($book['author'], 0, 15) . (strlen($book['author']) > 15 ? '..' : '')) ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                            $books_displayed++;
                        endforeach;
                        ?>
                    </div>

                    <!-- Discover More button if there are more books to display -->
                    <?php if (count($books) > $books_display_limit): ?>
                        <div class="text-center mt-3">
                            <a class="btn main-btn" href="index.php?category=<?php echo urlencode($category); ?>">
                                Discover More in <?php echo htmlspecialchars($category); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php echo $empty_msg; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/scripts.js"></script>
</body>
</html>
