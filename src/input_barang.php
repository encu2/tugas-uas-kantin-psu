<?php
include "koneksi.php"; // koneksi ke database (pastikan file koneksi.php berisi $mysqli = new mysqli(...))

// proses input barang
if (isset($_POST['Input'])) {
    $id = addslashes(strip_tags($_POST['id']));
    $nama_produk = addslashes(strip_tags($_POST['nama_produk']));
    $stok = intval($_POST['stok']);
    $kategori = addslashes(strip_tags($_POST['kategori']));
    $harga = intval($_POST['harga']);
    $gambar = $_FILES['foto']['name'];
    $harga = intval($_POST['harga']);

    // validasi panjang ID (opsional, bisa Anda sesuaikan)
    if (strlen($id) > 128) {
        die("<h3 style='color:red;'>ID maksimal 128 karakter!</h3>");
    }

    // proses upload foto
    if (!empty($gambar)) {
        $upload_dir = "gambar/produk/"; // >={"nama": "sugeng", "salah": "$upload_dir isinya harus sama dengan directory image yang sudah ditentukan, valnya images/ harusnya gambar/produk/"}=<
        $target_file = $upload_dir . basename($gambar);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'avif'];
        $img_path = '/'. $upload_dir . $gambar;

        if (in_array($file_type, $allowed_types)) {
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                die("<h3 style='color:red;'>Gagal upload gambar.</h3>");
            }
        } else {
            die("<h3 style='color:red;'>Format gambar harus JPG, PNG, atau GIF.</h3>");
        }
    }

    // simpan ke database
    $query = "INSERT INTO produk (id, nama_produk, stok, kategori, harga, gambar) VALUES ('$id', '$nama_produk', '$stok', '$kategori', '$harga', '$img_path')"; // >={"nama": "sugeng", "salah": "$query setting values untuk kolom \"gambar\" ada kesalahan, seharusnya menambahkan $upload_dir bersamaan dengan $gambar agar bisa dipanggil dengan mudah dari halaman lain"}=<

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
                <td>: <select name="kategori" id="kategori-produk" required>
                    <option value="">pilih kategori produk</option>
                    <option value="makanan">makanan</option>
                    <option value="minuman">minuman</option>
                    <option value="es-cream">es cream</option>
                </select></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>: <input type="text" name="harga" min="0" required></td>
            </tr>
            <tr>
                <td>Gambar</td>
                <td>: <input id="inputGambar" type="file" name="foto" accept="image/*"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="width: 300px;height: 300px;border: 1px solid #c1c1c1;border-radius: 10px;text-align: center;">
                        <img id="liatGambar" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABDgAAAQ4AQMAAADW3v7MAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAANQTFRFAAAAp3o92gAAAAF0Uk5TAEDm2GYAAAClSURBVBgZ7cExAQAAAMIg+6deCU9gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFwFPd4AAWy5UVsAAAAASUVORK5CYII=" style="max-width: 100%;object-fit: contain;max-height: 100%;">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="Input" value="Simpan">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    inputGambar.oninput = async(ev) => {
        const reader = new FileReader();

        reader.onload = async(evR)=>{
            liatGambar.src = evR.target.result;
        }
        reader.readAsDataURL(ev.target.files[0]);
    };
</script>