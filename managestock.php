<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'manager') {
    header("Location: loginmanager.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $new_stock = $_POST['new_stock'];
    $stmt = $conn->prepare("UPDATE menu SET stok = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_stock, $menu_id);
    $stmt->execute();
    $stmt->close();
    header("Location: managestock.php?status=updated");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stok</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #34495e;
        }
        nav {
            background-color: #2c3e50;
            padding: 15px;
            width: 100%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }
        nav a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        nav a:hover {
            background-color: #1abc9c;
            border-radius: 5px;
            transform: scale(1.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            animation: fadeInDown 1s;
            background-color: rgba(0, 0, 0, 0.7);
            color: #ecf0f1;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
        }
        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            border: 1px solid #2c3e50;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5);
        }
        .menu-list {
            width: 30%;
            background-color: rgba(52, 73, 94, 0.8);
            overflow-y: auto;
            max-height: 600px;
        }
        .menu-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .menu-list li {
            padding: 15px;
            border-bottom: 1px solid #2c3e50;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .menu-list li:hover {
            background-color: #1abc9c;
            transform: scale(1.05);
        }
        .menu-details {
            width: 70%;
            padding: 20px;
            background-color: rgba(44, 62, 80, 0.8);
        }
        .menu-details img {
            max-width: 200px;
            height: auto;
            display: block;
            margin-bottom: 20px;
            border: 2px solid #2c3e50;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .menu-details img:hover {
            transform: scale(1.1);
        }
        .menu-details label {
            display: block;
            margin-top: 10px;
            font-size: 18px;
            color: #ecf0f1;
            font-weight: bold;
            text-transform: uppercase;
        }
        .menu-details input[type="text"],
        .menu-details input[type="number"] {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            background-color: #34495e;
            color: #ecf0f1;
            transition: background-color 0.3s ease;
        }
        .menu-details input[type="text"]:focus,
        .menu-details input[type="number"]:focus {
            background-color: #1abc9c;
            outline: none;
        }
        .manage-stock-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            border: 2px solid #e74c3c;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }
        .manage-stock-button:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            transform: scale(1.05);
        }
        .back-to-rekap {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .back-to-rekap:hover {
            background-color: #1abc9c;
            transform: scale(1.05);
        }
        .logout {
            color: red;
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
    <h2>Manage Stok Menu</h2>
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'updated') {
        echo '<p style="text-align: center; color: #1abc9c;">Stok berhasil diperbarui.</p>';
    }

    $result = $conn->query("SELECT id, nama, stok, harga, gambar FROM menu");
    $menu_list = [];
    while ($row = $result->fetch_assoc()) {
        $menu_list[] = $row;
    }
    ?>
    <div class="container">
        <div class="menu-list">
            <ul>
                <?php foreach ($menu_list as $menu): ?>
                    <li onclick='showMenuDetails(<?php echo json_encode($menu); ?>)'>
                        <?php echo htmlspecialchars($menu['nama']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="menu-details">
            <form method="POST" action="">
                <input type="hidden" id="menu-id" name="menu_id" value="">
                <label for="menu-nama">Nama Menu:</label>
                <input type="text" id="menu-nama" name="menu_nama" value="" readonly>
                <img id="menu-image" src="" alt="Menu Image">
                <label>Harga: <span id="menu-price"></span></label>
                <label for="menu-stock">Stok:</label>
                <input type="number" id="menu-stock" name="new_stock" value="" min="0">
                <button type="submit" class="manage-stock-button">Update Stok</button>
            </form>
        </div>
    </div>
    <a href="rekap.php" class="back-to-rekap"><i class="fas fa-arrow-left"></i> Kembali ke Rekap</a>
    <script>
        function showMenuDetails(menu) {
            document.getElementById('menu-id').value = menu.id;
            document.getElementById('menu-nama').value = menu.nama;
            document.getElementById('menu-stock').value = menu.stok;
            document.getElementById('menu-image').src = menu.gambar;
            document.getElementById('menu-price').innerText = menu.harga;
            document.querySelector('.menu-details').classList.add('animate__animated', 'animate__fadeInRight');
            setTimeout(() => {
                document.querySelector('.menu-details').classList.remove('animate__animated', 'animate__fadeInRight');
            }, 1000);
        }
    </script>
</body>
</html>
