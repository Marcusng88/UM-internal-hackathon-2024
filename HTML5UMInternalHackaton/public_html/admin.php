<?php
// admin.php

session_start();

// Path to the orders CSV file
$filePath = 'orders.csv';

// Read the orders from the CSV file
$orders = [];
if (file_exists($filePath)) {
    if (($file = fopen($filePath, 'r')) !== FALSE) {
        // Skip the header row
        fgetcsv($file);

        // Output the rows
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $orders[] = [
                'customer_name' => $data[0],
                'name' => $data[1],
                'quantity' => $data[2],
                'price' => $data[3],
                'total' => $data[4],
                'date' => $data[5]
            ];
        }
        fclose($file);
    }
}

// Handle CSV download request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['download_csv'])) {
    // Set headers to force file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="orders.csv"');
    readfile($filePath);
    exit();
}
?>
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
</head>
<body>
    <header>
        <h1>Admin Order Summary</h1>
    </header>

    <main class="container">
        <section class="order-summary">
            <h2>Orders</h2>
            <table border="1">
                <tr>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price (RM)</th>
                    <th>Total (RM)</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($order['price']); ?></td>
                    <td><?php echo htmlspecialchars($order['total']); ?></td>
                    <td><?php echo htmlspecialchars($order['date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- Download CSV Button -->
        <section class="download-csv">
            <form method="post" action="admin.php">
                <button type="submit" name="download_csv" class="btn btn-primary">Download Orders as CSV</button>
            </form>
        </section>
    </main>
    <br><br>
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