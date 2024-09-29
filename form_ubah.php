<html>
<head>
	<title>Ubah Berita</title>
	<style type="text/css">
      * {
        font-family: "Trebuchet MS";
      }
      h1 {
        text-transform: uppercase;
        color: #9400D3;
      }
    button {
          background-color: #9400D3;
          color: #fff;
          padding: 10px;
          text-decoration: none;
          font-size: 12px;
          border: 0px;
          margin-top: 20px;
    }
    label {
      margin-top: 10px;
      float: left;
      text-align: left;
      width: 100%;
    }
    input, select, textarea {
      padding: 6px;
      width: 100%;
      box-sizing: border-box;
      background: #f8f8f8;
      border: 2px solid #ccc;
      outline-color: salmon;
    }
    div {
      width: 100%;
      height: auto;
    }
    .base {
      width: 400px;
      height: auto;
      padding: 20px;
      margin-left: auto;
      margin-right: auto;
      background: #ededed;
    }
    </style>
</head>
<body>
<section class="base">
	<h1>Ubah Berita</h1>
	
	<?php
	include "koneksi.php";

	// Pastikan 'id_berita' ada di URL
	if (!isset($_GET['id_berita']) || empty($_GET['id_berita'])) {
		echo "<p>ID Berita tidak ditemukan.</p>";
		exit;
	}

	$id_berita = mysqli_real_escape_string($connect, $_GET['id_berita']);

	// Query untuk menampilkan data berita berdasarkan ID yang dikirim
	$query = "SELECT * FROM berita WHERE id_berita='$id_berita'";
	$sql = mysqli_query($connect, $query);

	if (!$sql) {
		echo "<p>Query Error: " . mysqli_error($connect) . "</p>";
		exit;
	}

	if (mysqli_num_rows($sql) == 0) {
		echo "<p>Data berita dengan ID $id_berita tidak ditemukan.</p>";
		exit;
	}

	$data = mysqli_fetch_array($sql);
	?>
	
	<form method="post" action="proses_ubah.php?id_berita=<?php echo htmlspecialchars($id_berita); ?>" enctype="multipart/form-data">
	<table cellpadding="8">
	<tr>
		<td>Judul Berita</td>
		<td><input type="text" name="judul_berita" value="<?php echo htmlspecialchars($data['judul_berita']); ?>"></td>
	</tr>
	<tr>
		<td>Isi Berita</td>
		<td><textarea name="isi_berita"><?php echo htmlspecialchars($data['isi_berita']); ?></textarea></td>
	</tr>
	<tr>
		<td>Kategori Berita</td>
		<td>
			<select name="id_kategori">
				<?php
				$kategori = mysqli_query($connect, "SELECT * FROM kategori_berita");
				while($row = mysqli_fetch_array($kategori)) {
					$selected = $row['id_kategori'] == $data['id_kategori'] ? 'selected' : '';
					echo "<option value='".$row['id_kategori']."' $selected>".$row['nama_kategori_berita']."</option>";
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Gambar</td>
		<td>
			<input type="checkbox" name="ubah_gambar" value="true"> Ceklis jika ingin mengubah gambar<br>
			<input type="file" name="gambar_berita">
		</td>
	</tr>
	<tr>
		<td>Tanggal Berita</td>
		<td><input type="date" name="tgl_berita" value="<?php echo htmlspecialchars($data['tgl_berita']); ?>"></td>
	</tr>
	</table>
	
	<hr>
	<div>
	<button type="submit" value="Ubah">Simpan Perubahan</button>
	<a href="index.php"><button type="button" value="Batal">Batal</button></a>
	</div>
	
	</section>
	</form>
</body>
</html>
