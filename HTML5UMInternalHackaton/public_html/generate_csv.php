<?php
// generate_csv.php

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Path to the orders CSV file
    $filePath = 'orders.csv';

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to download the file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Read the file and output its contents
        readfile($filePath);
        exit();
    } else {
        echo "No orders found.";
    }
}
?>