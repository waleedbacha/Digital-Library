<?php 
    include('dashboard_header.php');
     
    $query = "SELECT * FROM categories";
    $result = pg_query($conn, $query);  // Changed from mysqli_query to pg_query

    if(isset($_POST['add_cat'])){
        $cat_name = $_POST['cat_name'];

        $sql = "INSERT INTO categories (cat_name) VALUES ('$cat_name')";
        $sql_result = pg_query($conn, $sql);  // Changed from mysqli_query to pg_query

        if($sql_result){
            echo "<script> alert('Category added Successfully'); </script>";
        }else{
            echo "<script> alert('There was an error in adding category, Please try again later'); </script>";
        }

    }

?>

<div class="btn-container d-flex justify-content-end" style="margin-bottom: -40px;margin-top: 80px;margin-right: 50px;"><!-- Button to Trigger Popup -->
<button class="main-btn btn d" id="showPopup">Add Category</button>
</div>
<!-- Popup Modal -->
<div id="adduser" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-button" id="closePopup">&times;</span>
        <h2 class="text-center">Add Category</h2>
        <div class="form-cont">
            <form class="" method="POST" action="">
                <input type="text" class="form-control m-1" placeholder="Category Name" name="cat_name" />
                <input type="submit" name="add_cat"class="btn main-btn btn-block m-1" value="Add Category ">
            </form>
    </div>
</div>
</div>
<div class="main-table">


                    <table>
                        <thead>
                            <tr>
                                <td>Sr No</td>
                                <td>Category</td>
                                <td>Action</td>
                               
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                           $sr_no = 1;

                            

                            while ($data = pg_fetch_assoc($result)) {  // Changed from mysqli_fetch_assoc to pg_fetch_assoc
                              
                                $cat_id = $data['cat_id'];
                                $cat_name = $data['cat_name'];
                                

                                echo "<tr>
                                        <td>$sr_no</td>
                                        <td>$cat_name</td>
                                        <td><a href='cat_delete.php?cat_id=$cat_id'>Delete</a></td>
                                    </tr>";
                                
                                    $sr_no++;

                            }
                            ?>
                            

                        </tbody>
                    </table>
                </div>
        </div>

        <script>
document.addEventListener("DOMContentLoaded", function() {
    var showPopupButton = document.getElementById('showPopup');
    var popup = document.getElementById('adduser');
    var closeButton = document.getElementById('closePopup');

    // Show the popup
    showPopupButton.addEventListener('click', function() {
        popup.style.display = 'flex';
    });

    // Hide the popup when the close button is clicked
    closeButton.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Hide the popup if the user clicks outside of the popup content
    window.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
});
</script>

<?php 
    include('dashboard_footer.php');
?>
