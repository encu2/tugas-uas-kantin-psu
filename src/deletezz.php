<?php
include "koneksi.php";
if (isset($_GET['hihiduar'])) {
    $prod_id = $_GET['hihiduar'];
} else {
    die ("Error. No ID Selected! ");
}
?>
<div id="content">
    <?php
    //proses delete berita
    if (!empty($prod_id) && $prod_id != "") {
        $query = "DELETE FROM produk WHERE id='$prod_id'";
        $sql = $mysqli -> query ($query);

        if ($sql) {
            //Function call
            http_response_code(200);
            echo 1;
        } else {
            http_response_code(404);
            echo 0;
        }

    } else {
        die ("Access Denied");
    }
?>
</div>