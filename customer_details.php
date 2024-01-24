<?php
include 'connection.php'; 


  if (isset($_GET['id'])) {
    $cust_id = mysqli_real_escape_string($connect, $_GET['id']);


    
    $sql = "SELECT * FROM registeration WHERE Cust_id = $cust_id";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Customer Details</title>
            <style>
        .details-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .details-section h2 {
            color: #ff6600;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .details-sections p {
            margin: 5px 0;
            color: #333;
        }
        </style>
        </head>
        <body>
            <h1>Customer Details</h1>
            <div class='details-section'>
                <h2>User Information</h2>
                <p>Name: <?php echo $row['Name']; ?></p>
                <p>Email: <?php echo $row['Email']; ?></p>
                <p>Phone Number: <?php echo $row['Phonenumber']; ?></p>
                <p>License Number: <?php echo $row['Liscencenumber']; ?></p>
                <p>Address: <?php echo $row['address']; ?></p>
            </div>

            <div class='details-section'>
                <h2>Car Information</h2>
                <?php
                $carcode = $row['carcode'];
                $carQuery = "SELECT * FROM addcar WHERE carcode = '$carcode'";
                $carResult = $connect->query($carQuery);

                if ($carResult->num_rows > 0) {
                    $carRow = $carResult->fetch_assoc();
                    ?>
                    <p>Brand Name: <?php echo $carRow['brandname']; ?></p>
                    <p>Model Name: <?php echo $carRow['modelname']; ?></p>
                    <p>Color: <?php echo $carRow['color']; ?></p>
                    <?php
                } else {
                    echo "No car details found.";
                }
                ?>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Customer not found.";
    }
} else {
    echo "Invalid request. Customer ID not provided.";
}
?>