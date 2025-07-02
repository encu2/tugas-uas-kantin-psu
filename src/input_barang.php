<?php
include "koneksi.php"; // koneksi ke database (pastikan file koneksi.php berisi $mysqli = new mysqli(...))

// proses input barang
if (isset($_POST['Input'])) {
    $id = addslashes(strip_tags($_POST['id']));
    $nama_produk = addslashes(strip_tags($_POST['nama_produk']));
    $stok = intval($_POST['stok']);
    $kategori = addslashes(strip_tags($_POST['kategori']));
    $gambar = $_FILES['foto']['name'];

    // validasi panjang ID (opsional, bisa Anda sesuaikan)
    if (strlen($id) > 128) {
        die("<h3 style='color:red;'>ID maksimal 128 karakter!</h3>");
    }

    // proses upload foto
    if (!empty($gambar)) {
        $upload_dir = "images/";
        $target_file = $upload_dir . basename($gambar);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_type, $allowed_types)) {
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                die("<h3 style='color:red;'>Gagal upload gambar.</h3>");
            }
        } else {
            die("<h3 style='color:red;'>Format gambar harus JPG, PNG, atau GIF.</h3>");
        }
    }

    // simpan ke database
    $query = "INSERT INTO produk (id, nama_produk, stok, kategori, gambar)
              VALUES ('$id', '$nama_produk', '$stok', '$kategori', '$gambar')";

    if ($mysqli->query($query)) {
        echo "<h3 style='color:green;'>Data produk berhasil ditambahkan.</h3>";
    } else {
        echo "<h3 style='color:red;'>Gagal menambahkan data produk: " . $mysqli->error . "</h3>";
    }
}
?>

<!-- Form input produk -->
<div id="content">
    <h2>Form Input produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <table cellpadding="8">
            <tr>
                <td>ID</td>
                <td>: <input type="text" name="id" maxlength="128" required></td>
            </tr>
            <tr>
                <td>Nama Produk</td>
                <td>: <input type="text" name="nama_produk" maxlength="256" required></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td>: <input type="number" name="stok" min="0" required></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: <input type="text" name="kategori" maxlength="256" required></td>
            </tr>
            <tr>
                <td>Gambar</td>
                <td>: <input type="file" name="foto" accept="image/*"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="Input" value="Simpan">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
</div>
