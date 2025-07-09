<?php
include "koneksi.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){
?>
    <div id="content">
        <h2>Data Pegawai</h2>
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
                    <td><?= $gambar ?></td>
                    <td>
                        <a
                            href="index.php?page=edit&id=<?= $id ?>">Edit</a><br />
                        <a
                            href="index.php?page=delete&id=<?= $id ?>">Delete</a>
                    </td>
                </tr>
            <?php $no++;
            } ?>
        </table>
    </div>    
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
