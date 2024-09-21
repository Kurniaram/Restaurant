<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Automatically set the status of new orders to 'diproses'
$conn->query("UPDATE transaksi SET status='diproses' WHERE status='baru' AND DATE(tanggal) = CURDATE()");

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM transaksi WHERE id = $id");
    $conn->query("DELETE FROM detiltransaksi WHERE idtransaksi = $id");
    header("Location: transaksi.php");
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

        nav button {
            background-color: red;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        nav button:hover {
            background-color: darkred;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #375F1B;
            padding: 10px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #EBF7E3;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #66B032;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #9BD770;
            color: white;
        }

        td select {
            padding: 5px;
            border-radius: 5px;
        }

        td button {
            padding: 5px 10px;
            background-color: #66B032;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #375F1B;
        }

        nav .logout {
            background-color: red;
        }
    </style>
    <title>Transaksi</title>
</head>
<body>
<nav>
        <a href="index.php">Home</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="detiltransaksi.php">Detail Penjualan</a>
        <a href="rekap.php">Rekap</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
    <h2>Transaksi Hari Ini</h2>
    <table>
        <tr>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
            <th>Hapus</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM transaksi WHERE DATE(tanggal) = CURDATE()");
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['tanggal'] . '</td>
                    <td>' . $row['status'] . '</td>
                    <td>Rp' . $row['total'] . '</td>
                    <td>
                        <a href="nota.php?id=' . $row['id'] . '">View Nota</a>
                    </td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="' . $row['id'] . '">
                            <button type="submit" name="delete">Batalkan Pesanan</button>
                        </form>
                    </td>
                </tr>';
        }
        ?>
    </table>
</body>
</html>
