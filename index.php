<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process_order'])) {
    // Process order logic here
    $items = $_POST['items'];
    $date = date('Y-m-d H:i:s');
    $total = 0;

    // Insert into transaksi table
    $stmt = $conn->prepare("INSERT INTO transaksi (tanggal, total, status) VALUES (?, ?, 'diproses')");
    $stmt->bind_param("sd", $date, $total);
    $stmt->execute();
    $transaksi_id = $stmt->insert_id;
    $stmt->close();

    // Insert into detiltransaksi table and update total
    foreach ($items as $item_id => $qty) {
        if ($qty > 0) {
            $stmt = $conn->prepare("SELECT harga, stok FROM menu WHERE id = ?");
            $stmt->bind_param("i", $item_id);
            $stmt->execute();
            $stmt->bind_result($harga, $stok);
            $stmt->fetch();
            $stmt->close();

            // Update stok
            if ($stok >= $qty) {
                $new_stok = $stok - $qty;
                $stmt = $conn->prepare("UPDATE menu SET stok = ? WHERE id = ?");
                $stmt->bind_param("ii", $new_stok, $item_id);
                $stmt->execute();
                $stmt->close();
            } else {
                // Handle insufficient stock (optional)
                continue;
            }

            $total += $harga * $qty;

            // Update query and parameter binding according to the structure of the new detiltransaksi table
            $stmt = $conn->prepare("INSERT INTO detiltransaksi (idtransaksi, idmenu, jumlah) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $transaksi_id, $item_id, $qty);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Update total payment in transaksi table
    $stmt = $conn->prepare("UPDATE transaksi SET total = ? WHERE id = ?");
    $stmt->bind_param("di", $total, $transaksi_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to detailpesanan.php with the transaction ID
    header("Location: detailpesanan.php?id=$transaksi_id");
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
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        nav a {
            margin: 0 15px;
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
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        nav button:hover {
            background-color: darkred;
            transform: scale(1.1);
        }

        .welcome {
            background-color: rgba(255, 255, 255, 0.8);
            height: 200px;
            color: #1B3409;
            text-align: center;
            padding-top: 50px;
            font-size: 24px;
        }

        .menu-section {
            margin: 20px;
            text-align: center;
        }

        .menu-title {
            font-size: 24px;
            color: #375F1B;
            margin-bottom: 10px;
        }

        .menu-section h2 {
            position: relative;
            display: inline-block;
            padding: 0 10px;
            color: #375F1B;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .menu-section h2::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background-color: #375F1B;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .menu-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .menu-item {
            width: 18%;
            background-color: #EBF7E3;
            text-align: center;
            border: 1px solid #66B032;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .menu-item img {
            width: 200px;
            height: 200px;
            border-radius: 5px;
        }

        .menu-item p {
            margin: 10px 0;
            color: #375F1B;
        }

        .quantity-control button {
            background-color: #375F1B;
            border: none;
            color: white;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .quantity-control button:hover {
            background-color: #66B032;
        }

        input[type=number] {
            width: 30px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button.process_order {
            background-color: #375F1B;
            border: 2px solid #375F1B;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            cursor: pointer;
            border-radius: 8px;
            display: block;
            margin: 20px auto 0;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        button.process_order:hover {
            background-color: #66B032;
            border-color: #66B032;
        }

        .welcome h1 {
            color: #1B3409;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        nav .logout {
            background-color: red;
        }
    </style>
    <title>Welcome</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="detiltransaksi.php">Detail Penjualan</a>
        <a href="rekap.php">Rekap</a>
    </nav>
    <div class="welcome">
        <h1>Welcome to Our Restaurant</h1>
        <?php
        // Check if order has been processed
        if (isset($_SESSION['order_processed'])) {
            echo '<div style="background-color: #66B032; color: white; text-align: center; padding: 10px;">
                    Pesanan Anda telah diproses!
                  </div>';
            unset($_SESSION['order_processed']); // Clear session message
        }
        ?>
    </div>
    <form method="POST" action="index.php">
        <div class="menu-section">
            <h2>Makanan</h2>
            <div class="menu-items">
                <?php
                $result = $conn->query("SELECT * FROM menu WHERE kategori='makanan'");
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">
                            <img src="' . $row['gambar'] . '" alt="' . $row['nama'] . '">
                            <p>' . $row['nama'] . ' - Rp' . $row['harga'] . '</p>
                            <p>Stok: ' . $row['stok'] . '</p>
                            <div class="quantity-control">
                                <button type="button" onclick="decreaseQuantity(' . $row['id'] . ')">-</button>
                                <input type="number" name="items[' . $row['id'] . ']" id="item-' . $row['id'] . '" min="0" value="0">
                                <button type="button" onclick="increaseQuantity(' . $row['id'] . ')">+</button>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
        <div class="menu-section">
            <h2>Minuman</h2>
            <div class="menu-items">
                <?php
                $result = $conn->query("SELECT * FROM menu WHERE kategori='minuman'");
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">
                            <img src="' . $row['gambar'] . '" alt="' . $row['nama'] . '">
                            <p>' . $row['nama'] . ' - Rp' . $row['harga'] . '</p>
                            <p>Stok: ' . $row['stok'] . '</p>
                            <div class="quantity-control">
                                <button type="button" onclick="decreaseQuantity(' . $row['id'] . ')">-</button>
                                <input type="number" name="items[' . $row['id'] . ']" id="item-' . $row['id'] . '" min="0" value="0">
                                <button type="button" onclick="increaseQuantity(' . $row['id'] . ')">+</button>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
        <button type="submit" name="process_order" class="process_order">Proses Pesanan</button>
    </form>
    <script>
        function increaseQuantity(itemId) {
            var input = document.getElementById('item-' + itemId);
            input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantity(itemId) {
            var input = document.getElementById('item-' + itemId);
            if (input.value > 0) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</body>
</html>
