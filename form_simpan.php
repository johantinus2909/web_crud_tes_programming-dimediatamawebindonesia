<html>
<head>
    <title>Tambah Berita</title>
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
<center>
    <h1>Tambah Berita</h1>
    <form method="post" action="proses_simpan.php" enctype="multipart/form-data">
        <section class="base">
            <div>
                <label>Judul Berita</label>
                <input type="text" name="judul_berita" required="" />
            </div>
            <div>
                <label>Isi Berita</label>
                <textarea name="isi_berita" required=""></textarea>
            </div>
            <div>
                <label>Kategori Berita</label>
                <select name="id_kategori" required="">
                    <?php
                    include 'koneksi.php';
                    $kategori = mysqli_query($connect, "SELECT * FROM kategori_berita");
                    while($data = mysqli_fetch_array($kategori)) {
                        echo "<option value='".$data['id_kategori']."'>".$data['nama_kategori_berita']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Gambar</label>
                <input type="file" name="gambar_berita" required="" />
            </div>
            <div>
                <label>Tanggal Berita</label>
                <input type="date" name="tgl_berita" required="" />
            </div>
            <div>
                <button type="submit" value="Simpan">Simpan Berita</button>
                <a href="index.php"><button type="button" value="Batal">Batal</button></a>
            </div>
        </section>
    </form>
</center>
</body>
</html>
