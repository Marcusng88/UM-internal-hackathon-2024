<?php
// admin.php

// Example of accessing orders stored in a database or session
session_start();
$orders = isset($_SESSION['orders']) ? $_SESSION['orders'] : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['download_csv'])) {
    // Generate CSV file
    $csvContent = "Customer Name, Item Name, Quantity, Price (RM)\n";
    foreach ($orders as $order) {
        $csvContent .= "{$order['customer_name']}, {$order['name']}, {$order['quantity']}, " . number_format($order['price'] * $order['quantity'], 2) . "\n";
    }
    
    // Set headers to force file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="orders.csv"');
    echo $csvContent;
    exit();
}
?>
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
<!DOCTYPE html>
<html>
<head>
    <title>Admin Order Summary</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- assets/CSS -->
    <link rel="stylesheet" href="assets/CSS/style2.css">
    <link href="assets/CSS/custom.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const downloadButton = document.getElementById("download-csv");
            const errorMessage = document.getElementById("error-message");
            let ordersExist = false;

            // Check if there are any orders stored in sessionStorage
            for (let key in sessionStorage) {
                if (sessionStorage.hasOwnProperty(key) && key.startsWith("customer_")) {
                    ordersExist = true;
                    break;
                }
            }

            // Enable the download button if orders are found, else show error message
            if (ordersExist) {
                downloadButton.disabled = false;
            } else {
                errorMessage.textContent = "No orders found in session storage.";
            }

            // Event listener for the download button click
            downloadButton.addEventListener("click", function () {
                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Customer Name,Item Name,Quantity,Price (RM)\n";

                // Loop through all customer orders and add them to the CSV
                for (let key in sessionStorage) {
                    if (sessionStorage.hasOwnProperty(key) && key.startsWith("customer_")) {
                        let customer = JSON.parse(sessionStorage.getItem(key));
                        customer.orders.forEach(order => {
                            csvContent += `${customer.name},${order.name},${order.quantity},${(order.price * order.quantity).toFixed(2)}\n`;
                        });
                    }
                }

                // Create a download link and trigger it
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "all_orders.csv");
                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
            });
        });
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Admin Order Summary</h1>
    </header>

    <main class="container">
        <section class="order-summary">
            <h2>All Orders</h2>

            <button id="download-csv" disabled>Download All Orders as CSV</button>
            <p class="message" id="error-message"></p>
        </section>
    </main>

    <footer>
        <div class="image-container3">
            <a href="https://www.google.com/maps/dir//607,+Jalan+17%2F10,+Seksyen+17,+46400+Petaling+Jaya,+Selangor/@3.1222898,101.5533822,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x31cc495d298b9beb:0xfe6a13c3cd6df28d!2m2!1d101.6357842!2d3.122293?entry=ttu&g_ep=EgoyMDI0MTExOS4yIKXMDSoASAFQAw%3D%3D" target="_self" title="Our Location">
                <img src="assets/Images/GM icon.png" width="60" height="60" alt="KIMSENG official IG"/>
            </a>
            <a href="https://www.instagram.com/brayden_cjr05/?__pwa=1" target="_self" title="KIMSENG official IG">
                <img src="assets/Images/IG img.png" width="60" height="60" alt="KIMSENG official IG"/>
            </a>
        </div>
        <br>
        <p><strong>&copy Karisma Maju Mulia</strong></p>
    </footer>
</body>
</html>

