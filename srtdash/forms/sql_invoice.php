<?php
session_start();
include '../db_connect.php';


// Success message holder
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_no = $_POST['invoice_no'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $customer = $_POST['customer'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $currency = $_POST['currency'];




    // Check if invoice already exists
    $check = $conn->prepare("SELECT 1 FROM invoices WHERE `invoice_no` = ?");
    $check->bind_param("s", $invoice_no);
    $check->execute();
    $check->store_result();
    
    if ($check->num_rows > 0) {
        header("Location: ../add_invoice.php?error=duplicate");
        exit();
    } else {
        $statement = $conn->prepare("INSERT INTO invoices (invoice_no, amount, date, customer, due_date, status, currency) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($statement) {
            $statement->bind_param("sssssss", $invoice_no, $amount, $date, $customer, $due_date, $status, $currency);
            if ($statement->execute()) {
                header("Location: ../add_invoice.php?success=1");
                 exit();
            } else {
                header("Location: ../add_invoice.php?success=0");
            }
    }
}
 
    $check->close();
    $conn->close();
}
?>
