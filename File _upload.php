<?php 

    // Database connection
    require_once "config.php";
    
    if(isset($_POST["submit"])) {
        // Set image placement folder
        $target_dir = "file_dir/";
        // Get file path
        $target_file = $target_dir . basename($_FILES["uplodedfile"]["name"]);
        // Get file extension
        $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("jpg", "jpeg", "png" , "pdf" , "docs");
        

        if (!file_exists($_FILES["uplodedfile"]["tmp_name"])) {
           $resMessage = array(
               "status" => "alert-danger",
               "message" => "Select file to upload."
           );
        } else if (!in_array($fileExt, $allowd_file_ext)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "Allowed file formats .jpg, .jpeg and .png."
            );            
        } else if ($_FILES["uplodedfile"]["size"] > 2097152) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File is too large. File size should be less than 2 megabytes."
            );
        } else if (file_exists($target_file)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File already exists."
            );
        } else {
            if (move_uploaded_file($_FILES["uplodedfile"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO pap_view (uplodedfile) VALUES ('$target_file')";
                $stmt =mysqli_prepare($link, $sql);
                 if($stmt->execute()){
                    $resMessage = array(
                        "status" => "alert-success",
                        "message" => "file uploaded successfully."
                    );                 
                 }
            } else {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "file coudn't be uploaded."
                );
            }
        }

    }

?>