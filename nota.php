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

// Process calculate change and update status to 'selesai'
if (isset($_POST['calculate_change'])) {
    $paid_amount = $_POST['paid_amount'];
    $change = $paid_amount - $transaction['total'];
    $conn->query("UPDATE transaksi SET status='selesai' WHERE id=$id");
    header("Location: nota.php?id=$id&change=$change");
    exit;
}

// Get change from URL parameter if set
$change = isset($_GET['change']) ? $_GET['change'] : null;

// Process print receipt
if (isset($_POST['print_receipt'])) {
    echo "<script>window.print();</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EBF7E3;
            background-image: url('background.jpeg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        nav {
            width: 100%;
            height: 30px;
            background-color: #375F1B;
            text-align: center;
            position: fixed;
            top: 0;
            z-index: 1000;
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

        nav .logout {
            background-color: red;
        }

        .content {
            margin-top: 80px; /* Adjust this value based on your navbar height */
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        table {
            width: 80%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #FFFFFF;
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

        textarea {
            width: 100%;
            height: 50px;
            margin: 10px 0;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: 20px 0;
        }

        .actions button {
            padding: 10px 20px;
            background-color: #66B032;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #375F1B;
        }

        .change {
            background-color: #FFD700;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
    <title>Nota</title>
</head>
<nav>
        <a href="index.php">Home</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="detiltransaksi.php">Detail Transaksi</a>
        <a href="rekap.php">Rekap</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
<body>

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
            <th>Sub Total Bayar</th>
            <td>Rp<?php echo $transaction['total']; ?></td>
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
                <td>Rp<?php echo $item['harga']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="2">Sub Total Bayar</th>
            <th>Rp<?php echo $transaction['total']; ?></th>
        </tr>
    </table>

    <div class="actions">
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
            <input type="text" name="paid_amount" placeholder="Jumlah Uang Dibayar">
            <button type="submit" name="calculate_change">Hitung Kembalian</button>
        </form>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
            <button type="submit" name="print_receipt">Cetak Nota</button>
        </form>
    </div>

    <?php if (isset($change)) { ?>
        <p class="change">Kembalian: Rp<?php echo $change; ?></p>
    <?php } ?>
</body>
</html>
