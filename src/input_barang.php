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

        /* Gaya untuk pesan respons/notifikasi */
        #respons {
            background-color: #d1fae5; /* Warna hijau terang */
            color: #065f46; /* Warna teks hijau gelap */
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            text-align: center;
            width: 100%;
            max-width: 1024px;
            box-sizing: border-box;
        }

        /* Gaya untuk container utama form */
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

        /* Gaya untuk judul form */
        h2 {
            font-size: 1.875rem; /* Ukuran font besar */
            font-weight: 700; /* Tebal */
            color: #1f2937; /* Warna teks gelap */
            margin-bottom: 1.5rem; /* Margin bawah */
            text-align: center;
        }

        /* Gaya dasar untuk tabel form */
        form table {
            width: 100%;
            border-collapse: collapse; /* Menghilangkan spasi antar sel */
        }

        /* Gaya untuk setiap sel data (td) */
        form table td {
            padding: 8px; /* Menggantikan cellpadding="8" */
            vertical-align: top; /* Rata atas untuk label dan input */
            color: #374151; /* Warna teks default */
        }

        /* Gaya khusus untuk sel label (kolom pertama) */
        form table td:first-child {
            width: 150px; /* Lebar tetap untuk label */
            font-weight: 500;
        }

        /* Gaya untuk input teks, angka, dan select */
        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 1rem); /* Mengisi lebar sisa, dikurangi margin/padding */
            padding: 0.75rem; /* Padding input */
            border: 1px solid #d1d5db; /* Warna border */
            border-radius: 0.375rem; /* Sudut membulat */
            font-size: 1rem; /* Ukuran font input */
            color: #1f2937;
            outline: none; /* Hapus outline default */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar input */
        }

        /* Gaya saat input fokus */
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #3b82f6; /* Warna border saat fokus */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Bayangan saat fokus */
        }

        /* Gaya untuk input file */
        input[type="file"] {
            width: calc(100% - 1rem); /* Mengisi lebar sisa */
            padding: 0.5rem; /* Padding lebih sedikit untuk input file */
            background-color: #f9fafb;
            cursor: pointer;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-sizing: border-box;
        }

        /* Gaya untuk container pratinjau gambar */
        .image-preview-container {
            width: 300px;
            height: 300px;
            border: 1px solid #c1c1c1;
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Pastikan gambar tidak keluar dari container */
            margin-top: 1rem; /* Jarak dari input file */
            background-color: #f9fafb;
            margin-left: auto; /* Pusatkan container gambar jika colspan 2 */
            margin-right: auto;
        }

        /* Gaya untuk gambar di dalam pratinjau */
        .image-preview-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Memastikan gambar pas di dalam container */
            display: block; /* Menghilangkan spasi bawah gambar */
        }

        /* Gaya untuk tombol submit dan reset */
        input[type="submit"],
        input[type="reset"] {
            display: inline-block;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            border: none;
            font-size: 1rem;
            margin-right: 1rem; /* Jarak antar tombol */
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #22c55e; /* Warna hijau */
            color: #ffffff;
        }

        input[type="submit"]:hover {
            background-color: #16a34a; /* Warna hijau lebih gelap saat hover */
        }

        input[type="reset"] {
            background-color: #6b7280; /* Warna abu-abu */
            color: #ffffff;
        }

        input[type="reset"]:hover {
            background-color: #4b5563; /* Warna abu-abu lebih gelap saat hover */
        }

        /* Responsif untuk kolom pada layar kecil */
        @media (max-width: 639px) { /* Di bawah breakpoint 'sm' */
            form table td:first-child {
                width: 100%; /* Label mengambil lebar penuh */
                display: block; /* Agar label berada di baris terpisah */
                padding-bottom: 0.25rem; /* Sedikit padding bawah */
            }
            form table td:nth-child(2) {
                display: block; /* Input juga di baris terpisah */
                width: 100%;
                padding-top: 0; /* Hapus padding atas jika label di atas */
            }
            /* Sesuaikan input agar mengambil lebar penuh di layar kecil */
            input[type="text"],
            input[type="number"],
            input[type="file"],
            select {
                width: 100%;
            }
            /* Tombol akan mengambil lebar penuh dan ditumpuk */
            input[type="submit"],
            input[type="reset"] {
                width: calc(100% - 1rem); /* Kurangi padding untuk lebar penuh */
                margin-right: 0;
                margin-bottom: 0.75rem; /* Jarak antar tombol di layar kecil */
            }
            form table tr:last-child td {
                padding-top: 1rem; /* Tambah padding atas untuk baris tombol */
                text-align: center; /* Pusatkan tombol */
            }
            .image-preview-container {
                width: 100%; /* Lebar penuh untuk pratinjau gambar */
                height: 200px; /* Tinggi disesuaikan */
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
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
                    <input type="submit" name="Input" value="Simpan" style="margin-bottom: 10px;">
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