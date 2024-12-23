<?php
if(isset($_FILES['coverImage'])){
    $coverImage = $_FILES['coverImage'];
    $target_dir = "uploads/cover/";
    $target_file = $target_dir . basename($coverImage["name"]);
    
    if (move_uploaded_file($coverImage["tmp_name"], $target_file)) {
        echo basename($coverImage["name"]);  // Return the file name
    } else {
        http_response_code(500);
        echo "Error uploading file.";
    }
}
?>
