<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'manager') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #375F1B;
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            margin: 10px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #66B032;
        }

        nav form {
            display: inline-block;
        }

        nav form button {
            background-color: red;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        nav form button:hover {
            background-color: darkred;
        }

        h2, h3 {
            text-align: center;
            margin-top: 20px;
            color: #1B3409;
            padding: 10px;
            border-radius: 5px;
            background-color: rgba(235, 247, 227, 0.8);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #375F1B;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e5e5e5;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="date"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        button[type="submit"] {
            background-color: #375F1B;
            border: none;
            color: white;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #66B032;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        p {
            text-align: center;
            font-weight: bold;
            color: #333;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            padding: 10px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: right;
            margin-top: 10px;
        }

        .footer p {
            font-size: 14px;
            color: #333;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }

        nav .logout {
            background-color: red;
        }

        .manage-stock-button, .update-menu-button {
            display: inline-block;
            margin: 20px 10px;
            padding: 5px 10px;
            background-color: #375F1B;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            border: 2px solid #375F1B;
        }

        .manage-stock-button:hover, .update-menu-button:hover {
            background-color: #66B032;
            border-color: #66B032;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .rekap-container {
            display: none;
        }

        .toggle-button {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #375F1B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        .toggle-button:hover {
            background-color: #66B032;
            transition: background-color 0.3s ease;
        }
    </style>
    <title>Rekap Transaksi</title>
    <script>
        function toggleRekap() {
            var rekapContainer = document.getElementById('rekap-container');
            if (rekapContainer.style.display === 'none') {
                rekapContainer.style.display = 'block';
            } else {
                rekapContainer.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<nav>
    <a href="index.php">Home</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="detiltransaksi.php">Detail Penjualan</a>
    <a href="rekap.php">Rekap</a>
    <a href="logout.php" class="logout">Logout</a>
</nav>
<h2>Rekap Transaksi</h2>
<button class="toggle-button" onclick="toggleRekap()">Tampilkan Laporan Penjualan</button>
<div id="rekap-container" class="rekap-container">
    <?php
    // Default SQL query to fetch all transactions
    $sql = "SELECT DISTINCT DATE(tanggal) AS tanggal, SUM(total) AS total_pendapatan 
            FROM transaksi 
            GROUP BY DATE(tanggal)";
    $result = $conn->query($sql);
    ?>
    <h3>Total Pendapatan</h3>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Total Pendapatan</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['tanggal'] . '</td>
                    <td>Rp' . $row['total_pendapatan'] . '</td>';
        }
        ?>
    </table>
    <?php
    // SQL query to fetch all sold menu items and sum the quantities
    $sql = "SELECT menu.nama, DATE(transaksi.tanggal) AS tanggal, SUM(detiltransaksi.jumlah) AS total_jumlah 
            FROM detiltransaksi 
            JOIN menu ON detiltransaksi.idmenu = menu.id 
            JOIN transaksi ON detiltransaksi.idtransaksi = transaksi.id 
            GROUP BY menu.nama, DATE(transaksi.tanggal)";
    $result = $conn->query($sql);

    // Array to store aggregated menu sales
    $aggregated_sales = [];
    $dates = [];

    // Process query results to aggregate sales by menu
    while ($row = $result->fetch_assoc()) {
        $menu_name = $row['nama'];
        $tanggal = $row['tanggal'];
        $total_jumlah = $row['total_jumlah'];

        // If menu name already exists, add to the existing total
        if (!isset($aggregated_sales[$menu_name])) {
            $aggregated_sales[$menu_name] = [];
        }
        $aggregated_sales[$menu_name][$tanggal] = $total_jumlah;

        // Add date to dates array if not already present
        if (!in_array($tanggal, $dates)) {
            $dates[] = $tanggal;
        }
    }

    // Sort dates
    sort($dates);
    ?>
    <h3>Menu Terjual</h3>
    <table>
        <tr>
            <th>Nama Menu</th>
            <?php foreach ($dates as $date) {
                echo '<th>' . $date . '</th>';
            } ?>
        </tr>
        <?php
        foreach ($aggregated_sales as $menu_name => $sales_by_date) {
            echo '<tr>
                    <td>' . $menu_name . '</td>';
            foreach ($dates as $date) {
                echo '<td>' . (isset($sales_by_date[$date]) ? $sales_by_date[$date] : 0) . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>
<div class="container">
    <a href="managestock.php" class="manage-stock-button">Manage Stok</a>
    <a href="updatemenu.php" class="update-menu-button">Update Menu</a>
</div>
</body>
</html>
