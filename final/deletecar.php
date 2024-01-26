<?php
include 'connection.php';

$carcode = filter_input(INPUT_GET, 'carcode', FILTER_SANITIZE_STRING);

if (!$carcode) {
  die("Invalid car code");
}

$sql = "DELETE FROM addcar WHERE carcode = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $carcode);
$stmt->execute();
$stmt->close();
mysqli_close($connect);

header("Location: manage_car.php?deleted=success");
?>