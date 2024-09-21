<?php
require 'db.php';

$id = $_GET['id'];

// Fetch transaction details
$stmt = $conn->prepare("SELECT * FROM transaksi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();
$stmt->close();

// Fetch transaction items
$stmt = $conn->prepare("SELECT dt.*, m.nama as nama_menu, m.harga FROM detiltransaksi dt JOIN menu m ON dt.idmenu = m.id WHERE dt.idtransaksi = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            background-image: url('background.jpeg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        nav {
            width: 100%;
            background-color: #375F1B;
            text-align: center;
            position: fixed;
            top: 0;
            z-index: 1000;
            animation: slideInDown 1s ease-in;
        }

        @keyframes slideInDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        nav a {
            margin: 10px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            background-color: #66B032;
            transform: scale(1.1);
        }

        .content {
            margin-top: 100px;
            width: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-in;
        }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        h2 {
            margin-bottom: 20px;
            color: #375F1B;
            transition: color 0.3s ease;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #FFFFFF;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            animation: fadeIn 1s ease-in;
        }

        th, td {
            border: 1px solid #66B032;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        th {
            background-color: #9BD770;
            color: white;
        }

        th:hover, td:hover {
            background-color: #E5E5E5;
        }

        .actions {
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 20px 0;
        }

        .actions a {
            text-decoration: none;
        }

        .actions button {
            padding: 10px 20px;
            background-color: #66B032;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .actions button:hover {
            background-color: #375F1B;
            transform: scale(1.1);
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            width: 100%;
            transition: color 0.3s ease;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Detail Pesanan</title>
</head>
<body>

<div class="content">
    <h2>Keranjang Pesanan</h2>
    <table>
        <tr>
            <th>ID Pesanan</th>
            <td><?php echo $transaction['id']; ?></td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td><?php echo $transaction['tanggal']; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo $transaction['status']; ?></td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Nama Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
        </tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?php echo $item['nama_menu']; ?></td>
                <td><?php echo $item['jumlah']; ?></td>
                <td>Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="total">
        Total: Rp<?php 
            $total = 0;
            foreach ($items as $item) {
                $total += $item['jumlah'] * $item['harga'];
            }
            echo number_format($total, 0, ',', '.');
        ?>
    </div>

    <div class="actions">
        <a href="index.php"><button>Kembali ke Menu</button></a>
    </div>
</div>

<script>
    // Change color of total based on amount
    document.addEventListener("DOMContentLoaded", function() {
        const total = <?php echo $total; ?>;
        const totalElement = document.querySelector('.total');
        if (total > 100000) {
            totalElement.style.color = 'red';
        } else if (total > 50000) {
            totalElement.style.color = 'orange';
        } else {
            totalElement.style.color = 'green';
        }
    });

    // Add hover effect to table rows
    document.querySelectorAll('table tr').forEach(row => {
        row.addEventListener('mouseover', () => {
            row.style.backgroundColor = '#f2f2f2';
        });
        row.addEventListener('mouseout', () => {
            row.style.backgroundColor = '';
        });
    });

    // Add click effect to button
    document.querySelector('.actions button').addEventListener('mousedown', () => {
        document.querySelector('.actions button').style.transform = 'scale(0.95)';
    });
    document.querySelector('.actions button').addEventListener('mouseup', () => {
        document.querySelector('.actions button').style.transform = 'scale(1)';
    });
</script>

</body>
</html>
