<?php 
    include('dashboard_header.php');
     
    $query = "SELECT * FROM books";
    $result = pg_query($conn, $query);  // Changed from mysqli_query to pg_query
    $keyword = '';
    if (isset($_GET['search'])) {
        $keyword = $_GET['keyword'];  
    }

    $sql = "SELECT * FROM books WHERE book_title LIKE '%$keyword%' OR author LIKE '%$keyword%' OR category LIKE '%$keyword%'";
    $result = pg_query($conn, $sql);  // Changed from mysqli_query to pg_query
    

?>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
        <form method="GET" action="" class="d-flex mt-5 ml-5" style="margin-bottom: -49px;">
            <input class="form-control" type="text" name="keyword" placeholder="Search">
            <input type="submit" name="search" class="btn main-btn ml-1" value="Search">
        </form>
        </div>
    </div>
    
</div>
<div class="main-table">
    <table>
        <thead>
        
            <tr>
                <td>Book Id</td>
                <td>Book Title</td>
                <td>Author</td>
                <td>Publisher</td>
                <td>Edition</td>
                <td>Action</td>
            </tr>
        </thead>

        <tbody>
        <?php
            $srno = 1;

            while ($data = pg_fetch_assoc($result)) {  // Changed from mysqli_fetch_assoc to pg_fetch_assoc
                $id = $data['book_id'];
                $isbn = $data['isbn'];
                $book_title = $data['book_title'];
                $author = $data['author'];
                $publisher = $data['publisher'];
                $edition = $data['edition'];
                $volume = $data['volume'];
                $year = $data['year'];

                echo "<tr>
                        <td>$id</td>
                        <td>$book_title</td>
                        <td>$author</td>
                        <td>$publisher</td>
                        <td>$edition</td>
                        <td><a href='book-edit.php?book_id=$id'>Edit</a> | <a href='book_delete.php?delete_id=$id'>Delete</a></td>
                    </tr>";

                $srno++; 
            }
        ?>
            
        </tbody>
    </table>
</div>
</div>

<?php 
    include('dashboard_footer.php');
?>
