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
    <title>Detail Transaksi</title>
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
            background-color: #EBF7E3;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #66B032;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #9BD770;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #D5E8C2;
        }

        tr:hover {
            background-color: #C3DDA5;
        }

        nav .logout {
            background-color: red;
        }
    </style>
</head>
<body>
<nav>
        <a href="index.php">Home</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="detiltransaksi.php">Detail Penjualan</a>
        <a href="rekap.php">Rekap</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
    <h2>Menu Paling Laris Terjual</h2>
    <table>
        <tr>
            <th>ID Menu</th>
            <th>Nama Menu</th>
            <th>Total Terjual</th>
        </tr>
        <?php
        $result = $conn->query("SELECT menu.id, menu.nama, SUM(detiltransaksi.jumlah) AS total_terjual 
                                FROM detiltransaksi 
                                JOIN menu ON detiltransaksi.idmenu = menu.id 
                                JOIN transaksi ON detiltransaksi.idtransaksi = transaksi.id 
                                GROUP BY menu.id, menu.nama
                                ORDER BY menu.id ASC");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $row['total_terjual'] . '</td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="3">Tidak ada transaksi yang ditemukan</td></tr>';
        }
        ?>
    </table>
</body>
</html>
