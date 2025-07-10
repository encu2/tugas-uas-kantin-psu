<?php
    include "koneksi.php"; // koneksi ke database (pastikan file koneksi.php berisi $mysqli = new mysqli(...))

    $id = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        die ("Error. No ID Selected! ");
    }

    $query = null;
    $sql = null;
    $hasil = null;
    $nama_produk = null;
    $stok = null;
    $kategori = null;
    $harga = null;
    $gambar = null;
    $upload_dir = "gambar/produk/";
    $img_path = null;

    if($_POST['update'] === 'updateLah'){
        $id = $_POST['id'];
        $nama_produk = stripslashes ($_POST['nama_produk']);
        $stok = intval($_POST['stok']);
        $kategori = stripslashes ($_POST['kategori']);
        $harga = stripslashes ($_POST['harga']);
        $gambar = $_FILES['gambar']['name'];
        $img_path = '/'. $upload_dir . $gambar;


        if (strlen($gambar) > 0){
            //upload
            if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
                move_uploaded_file ($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
            }
            $query = "UPDATE produk SET nama_produk='$nama_produk', stok='$stok', kategori='$kategori', harga='$harga', gambar='$img_path' WHERE id='$id'";
            $sql = $mysqli -> query($query);

            if ($sql) {
                // Function call
                echo "Berhasil Di Update";
            } else {
                echo "Gagal Di Update";
            }
        }
    }else if(empty($_POST['update'])){
        $query = "SELECT id, nama_produk, stok, kategori, harga, gambar FROM produk WHERE id='$id'";
        $sql = $mysqli -> query ($query);
        $hasil = $sql -> fetch_array(MYSQLI_ASSOC);
        $id = $hasil['id'];
        $nama_produk = stripslashes ($hasil['nama_produk']);
        $stok = intval($hasil['stok']);
        $kategori = stripslashes ($hasil['kategori']);
        $harga = stripslashes ($hasil['harga']);
        $gambar = stripslashes ($hasil['gambar']);
        $img_path = '/'. $upload_dir . $gambar;
    }else{
        die ("OFF");
    }
?>

<div id="content">
    <h2>Form Input produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="update" value="updateLah">
        <table cellpadding="8">
            <tr>
                <td>ID</td>
                <td>: <input type="text" name="id" maxlength="128" value="<?=$id?>" readonly="" required></td>
            </tr>
            <tr>
                <td>Nama Produk</td>
                <td>: <input type="text" name="nama_produk" maxlength="256" value="<?=$nama_produk?>" required></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td>: <input type="number" name="stok" min="0" value="<?=$stok?>" required></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: 
                    <select name="kategori" id="kategori-produk" required>
                        <?php
                        if($kategori === 'snack'){?>
                            <option value="snack" selected>makanan</option>
                            <option value="minuman">minuman</option>
                            <option value="es-cream">es cream</option>
                        <?php }else if($kategori === 'minuman'){?>
                            <option value="snack">makanan</option>
                            <option value="minuman" selected>minuman</option>
                            <option value="es-cream">es cream</option>
                        <?php }else if($kategori === 'es-cream'){?>
                            <option value="snack">makanan</option>
                            <option value="minuman">minuman</option>
                            <option value="es-cream" selected>es cream</option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>: <input type="text" name="harga" min="0" value="<?=$harga?>" required></td>
            </tr>
            <tr>
                <td>Gambar</td>
                <td>: <input id="inputGambar" type="file" name="gambar" accept="image/*"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="width: 300px;height: 300px;border: 1px solid #c1c1c1;border-radius: 10px;text-align: center;">
                        <img id="liatGambar" src="<?=$img_path?>" style="max-width: 100%;object-fit: contain;max-height: 100%;">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="submit" value="submit">
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