<?php
include "koneksi.php"; // koneksi ke database (pastikan file koneksi.php berisi $mysqli = new mysqli(...))

$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die ("Error. No ID Selected! ");
}

$query = "SELECT id, nama_produk, stok, kategori, harga, gambar FROM produk WHERE id='$id'";
$sql = $mysqli -> query ($query);
$hasil = $sql -> fetch_array(MYSQLI_ASSOC);
$id = $hasil['id'];
$nama_produk = stripslashes ($hasil['nama_produk']);
$stok = intval($hasil['stok']);
$kategori = stripslashes ($hasil['kategori']);
$harga = stripslashes ($hasil['harga']);
$gambar = stripslashes ($hasil['gambar']);
$upload_dir = "gambar/produk/";
$img_path = '/'. $upload_dir . $gambar;

if($_POST['update'] === 'updateLah'){
    $id = $_POST['id'];
    $nama_produk = stripslashes ($_POST['nama_produk']);
    $stok = intval($_POST['stok']);
    $kategori = stripslashes ($_POST['kategori']);
    $harga = stripslashes ($_POST['harga']);
    $gambar = stripslashes ($_POST['gambar']);

    if (strlen($gambar) > 0){
        //upload
        if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
            move_uploaded_file ($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
            $mysqli -> query ("UPDATE produk SET ='$gambar' WHERE id='$id'");
        }
        $query = "UPDATE produk SET nama_produk='$nama_produk', $stok='$stok', kategori='$kategori', harga='$harga', gambar='$gambar' WHERE id='$id'";
        $sql = $mysqli -> query($query);

        if ($sql) {
            // Function call
            echo "Berhasil Di Update";
        } else {
            echo "Gagal Di Update";
        }
    }
}

