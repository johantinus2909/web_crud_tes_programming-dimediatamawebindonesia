<?php
error_reporting(0);
include 'koneksi.php'; // Menyertakan file koneksi di bagian atas
?>
<html>
<head>
    <title>Daftar Berita</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .kategori-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Menyelaraskan item ke tengah */
            margin: 10px 0; /* Margin atas dan bawah */
        }

        .kategori-item {
            margin: 5px; /* Jarak antara item */
            padding: 10px 20px; /* Padding dalam item */
            background-color: #f0f0f0; /* Warna latar belakang item */
            border-radius: 5px; /* Sudut membulat */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Bayangan halus */
        }

        .kategori-item a {
            text-decoration: none; /* Menghilangkan garis bawah pada link */
            color: #9400D3; /* Warna teks */
            font-weight: bold; /* Tebal teks */
        }

        .kategori-item a:hover {
            color: #6a0dad; /* Warna teks saat hover */
        }
    </style>
</head>
<body>
    <center>
        <h1>Daftar Berita</h1>
        <a href="form_simpan.php">+Tambah Berita</a><br><br>
        <form action="" method="POST">
            <input type="text" name="query" placeholder="Cari Berita"/>
            <input type="submit" name="cari" value="Search" />
        </form>

        <h2>Kategori Berita</h2>
        <div class="kategori-container">
            <?php
            $kategori_query = mysqli_query($connect, "SELECT * FROM kategori_berita");
            while ($kategori = mysqli_fetch_array($kategori_query)) {
                echo "<div class='kategori-item'><a href='index.php?kategori=" . $kategori['id_kategori'] . "'>" . htmlspecialchars($kategori['nama_kategori_berita']) . "</a></div>";
            }
            ?>
        </div>

        <table border="1" width="100%">
            <tr>
                <th>No</th>
                <th>Judul Berita</th>
                <th>Isi Berita</th>
                <th>Gambar</th>
                <th>Tanggal Berita</th>
                <th>Kategori Berita</th>
                <th colspan="3">Aksi</th>
            </tr>
            <?php
            $no = 1;
            $query = $_POST['query'] ?? '';
            $kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';

            if ($query != '') {
                $select = mysqli_query($connect, "SELECT berita.*, kategori_berita.nama_kategori_berita 
                    FROM berita 
                    JOIN kategori_berita ON berita.id_kategori = kategori_berita.id_kategori
                    WHERE (judul_berita LIKE '%" . mysqli_real_escape_string($connect, $query) . "%' 
                        OR isi_berita LIKE '%" . mysqli_real_escape_string($connect, $query) . "%')"
                    . ($kategori_filter ? " AND berita.id_kategori = '$kategori_filter'" : ""));
            } else {
                $select = mysqli_query($connect, "SELECT berita.*, kategori_berita.nama_kategori_berita 
                    FROM berita 
                    JOIN kategori_berita ON berita.id_kategori = kategori_berita.id_kategori"
                    . ($kategori_filter ? " WHERE berita.id_kategori = '$kategori_filter'" : ""));
            }

            if (mysqli_num_rows($select)) {
                while ($data = mysqli_fetch_array($select)) {
            ?>
            <tr>
                <td><center><?php echo $no++ ?></center></td>
                <td><center><?php echo $data['judul_berita'] ?></center></td>
                <td><center><?php echo substr($data['isi_berita'], 0, 100) . '...' ?></center></td>
                <td><center><?php echo "<img src='images/".$data['gambar_berita']."' width='100' height='100'>"?></center></td>
                <td><center><?php echo $data['tgl_berita'] ?></center></td>
                <td><center><?php echo $data['nama_kategori_berita'] ?></center></td>
                <td><center><a href="detail_berita.php?id_berita=<?php echo $data['id_berita'] ?>">Lihat Detail</a></center></td>
                <td><center><a href="form_ubah.php?id_berita=<?php echo $data['id_berita'] ?>">Ubah</a></center></td>
                <td><center><a href="proses_hapus.php?id_berita=<?php echo $data['id_berita'] ?>" 
                onclick="return confirm('Apakah anda yakin ingin menghapus berita <?php echo $data['judul_berita']; ?>?')">Hapus</a></center></td>
            </tr>
            <?php }} else {
                echo '<tr><td colspan="9"><center> Tidak ada data</center></td></tr>';
            }?>
        </table>
    </center>
</body>
</html>
