<?php
include "koneksi.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){
?>
<style>
        /* Mengatur font Inter secara global */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f3f4f6; /* Latar belakang abu-abu terang */
            padding: 1rem; /* Padding default untuk body */
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar body */
        }

        /* Responsif padding untuk body */
        @media (min-width: 640px) { /* breakpoint 'sm' */
            body {
                padding: 1.5rem;
            }
        }
        @media (min-width: 1024px) { /* breakpoint 'lg' */
            body {
                padding: 2rem;
            }
        }

        /* Gaya untuk container utama tabel */
        #content {
            max-width: 1024px; /* Lebar maksimum container */
            width: 100%;
            background-color: #ffffff; /* Latar belakang putih */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Bayangan */
            border-radius: 0.5rem; /* Sudut membulat */
            padding: 1.5rem; /* Padding default */
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
        }

        /* Responsif padding untuk content */
        @media (min-width: 640px) { /* breakpoint 'sm' */
            #content {
                padding: 2rem;
            }
        }

        /* Gaya untuk judul tabel */
        h2 {
            font-size: 1.875rem; /* Ukuran font besar */
            font-weight: 700; /* Tebal */
            color: #1f2937; /* Warna teks gelap */
            margin-bottom: 1.5rem; /* Margin bawah */
            text-align: center;
        }

        /* Container untuk membuat tabel responsif secara horizontal */
        .table-responsive-container {
            overflow-x: auto; /* Memungkinkan scroll horizontal */
            border-radius: 0.5rem; /* Sudut membulat untuk container tabel */
            border: 1px solid #e5e7eb; /* Border untuk container tabel */
        }

        /* Gaya dasar untuk tabel */
        #tabel {
            width: 100%; /* Lebar penuh */
            border-collapse: collapse; /* Menghilangkan spasi antar sel */
            min-width: 700px; /* Minimal lebar tabel agar tidak terlalu sempit di layar kecil */
        }

        /* Gaya untuk header tabel */
        #tabel thead {
            background-color: #f9fafb; /* Latar belakang abu-abu terang */
        }

        #tabel th {
            padding: 0.75rem 1rem; /* Padding untuk header */
            text-align: left;
            font-size: 0.75rem; /* Ukuran font kecil */
            font-weight: 500; /* Ketebalan font */
            color: #6b7280; /* Warna teks abu-abu */
            text-transform: uppercase; /* Huruf kapital */
            letter-spacing: 0.05em; /* Jarak antar huruf */
        }

        /* Sudut membulat untuk header pertama dan terakhir */
        #tabel th:first-child {
            border-top-left-radius: 0.5rem;
        }

        #tabel th:last-child {
            border-top-right-radius: 0.5rem;
        }

        /* Gaya untuk baris di body tabel */
        #tabel tbody tr {
            background-color: #ffffff; /* Latar belakang putih default */
            border-bottom: 1px solid #e5e7eb; /* Garis pemisah antar baris */
        }

        /* Efek hover pada baris */
        #tabel tbody tr:hover {
            background-color: #f9fafb; /* Latar belakang abu-abu terang saat hover */
        }

        /* Gaya untuk baris genap (alternating row colors) */
        #tabel tbody tr:nth-child(even) {
            background-color: #f9fafb; /* Latar belakang abu-abu sangat terang */
        }

        #tabel tbody tr:nth-child(even):hover {
            background-color: #f3f4f6; /* Latar belakang abu-abu sedikit lebih gelap saat hover */
        }

        /* Gaya untuk sel data */
        #tabel td {
            padding: 1rem 1rem; /* Padding untuk sel data */
            white-space: nowrap; /* Mencegah teks wrap */
            font-size: 0.875rem; /* Ukuran font standar */
            color: #374151; /* Warna teks abu-abu gelap */
        }

        /* Gaya khusus untuk sel 'No' (kolom pertama) */
        #tabel td:first-child {
            font-weight: 500;
            color: #111827; /* Warna teks lebih gelap */
        }

        /* Gaya untuk gambar di dalam tabel */
        .table-image {
            width: 80px; /* Lebar gambar */
            height: 80px; /* Tinggi gambar */
            object-fit: cover; /* Memastikan gambar mengisi area tanpa terdistorsi */
            border-radius: 8px; /* Sudut membulat untuk gambar */
            display: block; /* Menghilangkan spasi bawah gambar */
            margin: 0 auto; /* Pusatkan gambar jika sel lebih lebar */
        }

        /* Gaya untuk tombol aksi (Edit/Delete) */
        .action-button {
            display: inline-block; /* Agar bisa berdampingan */
            font-weight: 600;
            padding: 0.5rem 0.75rem; /* Padding tombol */
            border-radius: 0.375rem; /* Sudut membulat */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Bayangan kecil */
            transition: all 0.15s ease-in-out; /* Transisi halus saat hover */
            text-decoration: none; /* Hapus garis bawah default */
            text-align: center;
            margin-bottom: 0.5rem; /* Jarak antar tombol saat menumpuk */
            width: 100%; /* Lebar penuh saat menumpuk */
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
        }

        /* Gaya khusus untuk tombol Edit */
        .action-button.edit {
            background-color: #3b82f6; /* Warna biru */
            color: #ffffff;
        }

        .action-button.edit:hover {
            background-color: #2563eb; /* Warna biru lebih gelap saat hover */
        }

        /* Gaya khusus untuk tombol Delete */
        .action-button.delete {
            background-color: #ef4444; /* Warna merah */
            color: #ffffff;
        }

        .action-button.delete:hover {
            background-color: #dc2626; /* Warna merah lebih gelap saat hover */
        }

        /* Responsif untuk tombol aksi */
        @media (min-width: 640px) { /* breakpoint 'sm' */
            .action-button {
                width: auto; /* Lebar otomatis agar berdampingan */
                margin-bottom: 0; /* Hapus margin bawah */
            }
            .action-button.edit {
                margin-right: 0.5rem; /* Jarak kanan antar tombol */
            }
        }
    </style>
<body style="padding-bottom: 100px;">
    <div id="content" style="position: relative;">
        <h2>Data Produk Kantin</h2>
        <table id="tabel">
            <tr>
                <th width="5%">No</td>
                <th width="10%">ID</td>
                <th width="20%">NAMA PRODUK</td>
                <th width="15%">STOK</td>
                <th width="20%">KATEGORI</td>
                <th width="30%">GAMBAR</td>
                <th>Action</td>
            </tr>
            <?php
            $no = 1;
            $query = "SELECT id, nama_produk, stok, kategori, gambar FROM produk ORDER BY id";
            $sql = $mysqli->query($query);
            while ($hasil =  $sql->fetch_array(MYSQLI_ASSOC)) {
                $id = $hasil['id'];
                $nama_produk = stripslashes($hasil['nama_produk']);
                $stok = $hasil['stok'];
                $kategori = stripslashes($hasil['kategori']);
                $gambar = stripslashes($hasil['gambar']);
                // 
                //tampilkan data pegawai 
            ?>
                <tr bgcolor="<?= $warna ?>">
                    <td><?= $no ?></td>
                    <td><?= $id ?></td>
                    <td><?= $nama_produk ?></td>
                    <td><?= $stok ?></td>
                    <td><?= $kategori ?></td>
                    <td><img src="<?= $gambar ?>" class="table-image"></td>
                    <td>
                        <a style="margin-bottom: 10px;"
                            href="update-produk-bre.php?id=<?= $id ?>" class="action-button edit">Edit</a><br />
                        <a
                            href="deletezz.php?hihiduar=<?= $id ?>" class="action-button delete">Delete</a>
                    </td>
                </tr>
            <?php $no++;
            } ?>
        </table>
        <a href="input_barang.php" style="position: absolute;right: 0;bottom: -70px;background-color: #32b134;box-shadow: 3px 5px 10px #b7b7b7;" class="action-button edit">Tambah +</a>
    </div>    
</body>
<?php } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $kategoriApa = empty($_POST['kategori']) == true ? 'snack' : $_POST['kategori'];
            var_dump($_POST['kategori']);
            $query = "SELECT * FROM produk WHERE kategori = '$kategoriApa'";
            $sql = $mysqli->query($query);
            while ($hasil =  $sql->fetch_array(MYSQLI_ASSOC)) {
                $nama_produk = stripslashes($hasil['nama_produk']);
                $stok = $hasil['stok'];
                $kategori = stripslashes($hasil['kategori']);
                $gambar = stripslashes($hasil['gambar']);
                $harga = $hasil['harga'];
        ?>
<div class="product-card">
                    <img src="<?= $gambar ?>">
                    <h3><?= $kategori ?></h3>
                    <p class="product-title"><?= $nama_produk ?></p>
                    <p class="price"><?= $harga ?></p>
                    <p class="stok">Stok: <?= $stok ?></p>
                    <a href="#" class="order btn">Order Now</a>
                </div>
    <?php 
    }
}


?>
