<?php
// Load file koneksi.php
include "koneksi.php";

// Pastikan 'id_berita' ada di URL dan tidak kosong
if (!isset($_GET['id_berita']) || empty($_GET['id_berita'])) {
    echo "ID Berita tidak ditemukan.";
    exit;
}

$id_berita = mysqli_real_escape_string($connect, $_GET['id_berita']);

// Query untuk menampilkan data berita berdasarkan ID yang dikirim
$query = "SELECT * FROM berita WHERE id_berita='$id_berita'";
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

// Hapus gambar dari folder
if (is_file("images/" . $data['gambar_berita']) && $data['gambar_berita'] !== '') {
    unlink("images/" . $data['gambar_berita']);
}

// Proses hapus data dari Database
$query = "DELETE FROM berita WHERE id_berita='$id_berita'";
$sql = mysqli_query($connect, $query);

if ($sql) {
    // Jika berhasil, redirect ke halaman index.php
    header("Location: index.php");
    exit;
} else {
    // Jika gagal, tampilkan pesan error
    echo "Maaf, Terjadi kesalahan saat mencoba untuk menghapus data dari database.";
    echo "<br><a href='index.php'>Kembali Ke Halaman Utama</a>";
}
?>
