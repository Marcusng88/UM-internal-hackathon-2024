<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['payment-evidence']['name']);
    $username = $_POST['username'];
    $orderData = json_decode($_POST['order-data'], true);
    $totalItems = $_POST['total-items'];
    $totalPrice = $_POST['total-price'];

    // Save the order data to a CSV file
    $fileExists = file_exists('orders.csv');
    $file = fopen('orders.csv', 'a');
    if (!$fileExists) {
        fputcsv($file, ['username', 'name', 'quantity', 'price', 'total', 'date']);
    }
    $date = date('Y-m-d');
    foreach ($orderData as $item) {
        fputcsv($file, [$username, $item['name'], $item['quantity'], $item['price'], $item['total'], $date]);
    }
    fclose($file);

    // Handle the file upload
    if (move_uploaded_file($_FILES['payment-evidence']['tmp_name'], $uploadFile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }

    // Redirect to a thank you page
    header('Location: thank_you.php');
    exit();
}
?>