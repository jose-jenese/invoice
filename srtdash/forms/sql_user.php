<?php
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = $_POST['company'];
    $primary_contact = $_POST['primary_contact'];
    $primary_email = $_POST['primary_email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pin_code = $_POST['pin_code'];
    $country = $_POST['country'];


    $statement = $conn->prepare("INSERT INTO user (company, primary_contact, primary_email, city, state, pin_code, country) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$statement) {
        die("Prepare failed: " . $conn->error);
    }

    if ($statement) {
        $statement->bind_param("sssssss", $company, $primary_contact, $primary_email, $city, $state, $pin_code, $country);
        if ($statement->execute()) {
            header("Location: ../add_user.php?success=1");
             exit();
        } else {
            header("Location: ../add_user.php?success=0");
        }
}


$check->close();
$conn->close();
}
?>
