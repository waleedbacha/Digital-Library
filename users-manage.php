<?php 
    include('dashboard_header.php');
     
    $query = "SELECT * FROM users";
    $result = pg_query($conn, $query);  // Changed from mysqli_query to pg_query

    if(isset($_POST['add_user'])){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO users (name, phone, username, password) VALUES ('$name', '$phone', '$username', '$password')";
        $sql_result = pg_query($conn, $sql);  // Changed from mysqli_query to pg_query

        if($sql_result){
            echo "<script> alert('User added Successfully'); </script>";
        }else{
            echo "<script> alert('There was an error in adding user, Please try again later'); </script>";
        }

    }

?>

<div class="btn-container d-flex justify-content-end" style="margin-bottom: -40px;margin-top: 80px;margin-right: 50px;"><!-- Button to Trigger Popup -->
<button class="main-btn btn d" id="showPopup">Add User</button>
</div>
<!-- Popup Modal -->
<div id="adduser" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-button" id="closePopup">&times;</span>
        <h2 class="text-center">Add User</h2>
        <div class="form-cont">
            <form class="" method="POST" action="">
                <input type="text" class="form-control m-1" placeholder="Name" name="name" />
                <input type="text" class="form-control m-1" placeholder="Phone" name="phone" />
                <input type="text" class="form-control m-1" placeholder="Username" name="username" />
                <input type="text" class="form-control m-1" placeholder="Password" name="password" />
                <input type="submit" name="add_user"class="btn main-btn btn-block m-1" value="Add User">
            </form>
    </div>
</div>
</div>
<div class="main-table">


                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Phone</td>
                                <td>Username</td>
                                <td>Action</td>
                               
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                           

                            

                            while ($data = pg_fetch_assoc($result)) {  // Changed from mysqli_fetch_assoc to pg_fetch_assoc
                              
                                $id = $data['user_id'];
                                $name = $data['name'];
                                $phone = $data['phone'];
                                $username = $data['username'];
                                

                                echo "<tr>
                                        <td>$id</td>
                                        <td>$name</td>
                                        <td>$phone</td>
                                        <td>$username</td>
                                        <td><a href='user-edit.php?user_id=$id'>Edit</a> | <a href='user_delete.php?user_id=$id'>Delete</a></td>
                                    </tr>";

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
