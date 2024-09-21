<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'manager') {
    header("Location: login.php");
    exit;
}

// Handle menu deletion
if (isset($_POST['delete_menu'])) {
    $idmenu = $_POST['idmenu'];
    $sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idmenu);
    if ($stmt->execute()) {
        $delete_success = true;
    } else {
        $delete_error = true;
    }
}

// Handle menu price update
if (isset($_POST['update_price'])) {
    $idmenu = $_POST['idmenu'];
    $harga = $_POST['harga'];
    $sql = "UPDATE menu SET harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $harga, $idmenu);
    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $update_error = true;
    }
}

// Handle menu addition
if (isset($_POST['add_menu'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['gambar']['tmp_name']);
    if($check !== false) {
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO menu (nama, harga, stok, gambar) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siis", $nama, $harga, $stok, $target_file);
            if ($stmt->execute()) {
                $add_success = true;
            } else {
                $add_error = true;
            }
        } else {
            $add_error = true;
        }
    } else {
        $add_error = true;
    }
}

// Fetch all menu items
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav {
            background-color: #375F1B;
            padding: 10px;
            width: 100%;
            text-align: center;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #66B032;
        }

        nav .logout {
            background-color: red;
        }

        nav .logout:hover {
            background-color: darkred;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #1B3409;
            padding: 10px;
            border-radius: 5px;
            background-color: rgba(235, 247, 227, 0.8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #375F1B;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .form-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="text"], 
        .form-container input[type="number"], 
        .form-container input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button[type="submit"] {
            background-color: #375F1B;
            border: none;
            color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .form-container button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0;
        }

        .form-container button[type="submit"]:hover::before {
            width: 0;
            height: 0;
            opacity: 1;
        }

        .message {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            padding: 10px;
            background-color: #375F1B;
            color: white;
            font-size: 14px;
            border-top: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .footer p {
            margin: 0;
        }

        .button {
            background-color: #375F1B;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0;
        }

        .button:hover::before {
            width: 0;
            height: 0;
            opacity: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .fade-in {
            animation: fadeIn 2s forwards;
        }

        .fade-out {
            animation: fadeOut 1s forwards;
        }
    </style>
</head>
<body>
<nav>
    <a href="logout.php" class="logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>Update Menu</h2>

    <?php if (isset($delete_success)): ?>
        <p class="message success fade-in">Menu berhasil dihapus.</p>
    <?php elseif (isset($delete_error)): ?>
        <p class="message error fade-in">Terjadi kesalahan saat menghapus menu.</p>
    <?php endif; ?>

    <?php if (isset($update_success)): ?>
        <p class="message success fade-in">Harga menu berhasil diperbarui.</p>
    <?php elseif (isset($update_error)): ?>
        <p class="message error fade-in">Terjadi kesalahan saat memperbarui harga menu.</p>
    <?php endif; ?>

    <?php if (isset($add_success)): ?>
        <p class="message success fade-in">Menu berhasil ditambahkan.</p>
    <?php elseif (isset($add_error)): ?>
        <p class="message error fade-in">Terjadi kesalahan saat menambahkan menu.</p>
    <?php endif; ?>

    <h3>Menu Saat Ini</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID Menu</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td>Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline-block;">
                                <input type="hidden" name="idmenu" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_menu" class="button">Hapus</button>
                            </form>
                            <form method="POST" action="" style="display:inline-block;">
                                <input type="hidden" name="idmenu" value="<?php echo $row['id']; ?>">
                                <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
                                <button type="submit" name="update_price" class="button">Update Harga</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h3>Tambah Menu Baru</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="nama">Nama Menu:</label>
            <input type="text" id="nama" name="nama" required>
            
            <label for="harga">Harga (Rp):</label>
            <input type="number" id="harga" name="harga" required>
            
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" required>
            
            <label for="gambar">Gambar Menu:</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" required>
            
            <button type="submit" name="add_menu" class="button">Tambah Menu</button>
        </form>
    </div>

    <div class="footer">
        <form method="POST" action="rekap.php">
            <button type="submit" class="button"><i class="fa fa-arrow-left"></i> Kembali ke Rekap</button>
        </form>
    </div>
</div>

<script>
    // JavaScript for additional interactivity can be added here
    document.addEventListener("DOMContentLoaded", function() {
        // Handle fade-in and fade-out messages
        const messages = document.querySelectorAll('.message');
        messages.forEach(message => {
            message.classList.add('fade-in');
            setTimeout(() => {
                message.classList.add('fade-out');
            }, 3000);
        });

        // Button hover animation
        const buttons = document.querySelectorAll('.button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const span = document.createElement('span');
                span.classList.add('button-hover-effect');
                this.appendChild(span);
            });

            button.addEventListener('mouseleave', function() {
                const span = this.querySelector('.button-hover-effect');
                if (span) {
                    span.remove();
                }
            });
        });
    });
</script>
</body>
</html>
