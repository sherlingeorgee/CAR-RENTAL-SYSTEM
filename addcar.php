<?php
include 'connection.php';

// Function to get file size in MB
function getFileSizeMB($bytes) {
    return number_format($bytes / 1048576, 2);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file is uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        // Check file size
        $maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes
        if ($_FILES["image"]["size"] > $maxFileSize) {
            $errorMessage = "File size exceeds the maximum allowed (2 MB).";
        } else {
            // Proceed with form submission
            $code = $_POST["code"];
            $brand = $_POST["brand"];
            $model = $_POST["model"];
            $color = $_POST["color"];
            $reg_no = $_POST["reg_no"];
            $fuel_type = $_POST["fuel_type"];
            $seating_capacity = $_POST["seating_capacity"];
            $image = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $img_data = file_get_contents($image);

            // Prepare the SQL query with placeholders for data insertion
            $query = "INSERT INTO addcar (carcode, brandname, modelname, color, registeration_no, fuel_type, seating_capacity, car_image, image_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Prepare the statement
            $stmt = $connect->prepare($query);

            // Bind parameters and specify types
            $null = NULL;
            $stmt->bind_param("ssssssiss", $code, $brand, $model, $color, $reg_no, $fuel_type, $seating_capacity, $img_data, $image_name);
            
            // Execute the query
            $stmt->execute();

            // Check if insertion was successful
            if ($stmt->affected_rows > 0) {
                echo "Car details and image inserted successfully. <a href='admindashboard.php'>Go back to dashboard</a>";
                
            } else {
                echo "Error inserting data: " . $connect->error;
            }

            // Close statement and connection
            $stmt->close();
            $connect->close();
        }
    } else {
        $errorMessage = "Error uploading file.";
    }
}

// Display the error message if it's set
if (isset($errorMessage)) {
    echo "<p>Error: $errorMessage</p>";
}
?>
