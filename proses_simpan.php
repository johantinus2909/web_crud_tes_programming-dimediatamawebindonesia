<?php
// Load file koneksi.php
include "koneksi.php";

// Ambil Data yang Dikirim dari Form
$judul_berita = mysqli_real_escape_string($connect, $_POST['judul_berita']);
$isi_berita = mysqli_real_escape_string($connect, $_POST['isi_berita']);
$id_kategori = mysqli_real_escape_string($connect, $_POST['id_kategori']);
$tgl_berita = mysqli_real_escape_string($connect, $_POST['tgl_berita']); // Ambil tanggal dari form
$slug = strtolower(str_replace(' ', '-', $judul_berita)); // Membuat slug dari judul

// Cek apakah file gambar diunggah
if (isset($_FILES['gambar_berita']) && $_FILES['gambar_berita']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['gambar_berita']['name'];
    $tmp = $_FILES['gambar_berita']['tmp_name'];

    // Rename nama fotonya dengan menambahkan tanggal dan jam upload
    $fotobaru = date('dmYHis') . $foto;

    // Set path folder tempat menyimpan fotonya
    $path = "images/" . $fotobaru;

    // Proses upload
    if (move_uploaded_file($tmp, $path)) { // Cek apakah gambar berhasil diupload atau tidak
        // Proses simpan ke Database
        $query = "INSERT INTO berita (id_kategori, judul_berita, isi_berita, gambar_berita, tgl_berita, slug)
                  VALUES ('$id_kategori', '$judul_berita', '$isi_berita', '$fotobaru', '$tgl_berita', '$slug')";
        $sql = mysqli_query($connect, $query); // Eksekusi/ Jalankan query dari variabel $query

        if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
            header("Location: index.php"); // Redirect ke halaman index.php
            exit();
        } else {
            // Tampilkan pesan error dari MySQL
            echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            echo "<br>MySQL Error: " . mysqli_error($connect);
            echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
        }
    } else {
        echo "Maaf, Gambar gagal untuk diupload.";
        echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
    }
} else {
    echo "Maaf, tidak ada gambar yang diunggah atau terjadi kesalahan saat upload.";
    echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
}
?>
