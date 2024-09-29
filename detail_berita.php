<?php
error_reporting(0);
include 'koneksi.php';

// Pastikan 'id_berita' ada di URL dan tidak kosong
if (!isset($_GET['id_berita']) || empty($_GET['id_berita'])) {
    echo "ID Berita tidak ditemukan.";
    exit;
}

$id_berita = mysqli_real_escape_string($connect, $_GET['id_berita']);

// Query untuk menampilkan detail berita
$query = "SELECT berita.*, kategori_berita.nama_kategori_berita 
          FROM berita 
          JOIN kategori_berita ON berita.id_kategori = kategori_berita.id_kategori
          WHERE berita.id_berita='$id_berita'";
$sql = mysqli_query($connect, $query);

if (!$sql) {
    echo "Query Error: " . mysqli_error($connect);
    exit;
}

if (mysqli_num_rows($sql) == 0) {
    echo "Data berita dengan ID $id_berita tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Berita</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Menambahkan beberapa styling untuk halaman detail berita */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #9400D3;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #7a00b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Berita</h1>
        <table border="0" width="100%">
            <tr>
                <th>Judul Berita:</th>
                <td><?php echo htmlspecialchars($data['judul_berita']); ?></td>
            </tr>
            <tr>
                <th>Isi Berita:</th>
                <td><?php echo nl2br(htmlspecialchars($data['isi_berita'])); ?></td>
            </tr>
            <tr>
                <th>Gambar:</th>
                <td>
                    <?php if ($data['gambar_berita']) { 
                        echo "<img src='images/" . htmlspecialchars($data['gambar_berita']) . "' alt='Gambar Berita'>";
                    } else {
                        echo "Tidak ada gambar.";
                    } ?>
                </td>
            </tr>
            <tr>
                <th>Tanggal Berita:</th>
                <td><?php echo htmlspecialchars($data['tgl_berita']); ?></td>
            </tr>
            <tr>
                <th>Kategori Berita:</th>
                <td><?php echo htmlspecialchars($data['nama_kategori_berita']); ?></td>
            </tr>
        </table>
        <a href="index.php" class="back-button">Kembali ke Daftar Berita</a>
    </div>
</body>
</html>
