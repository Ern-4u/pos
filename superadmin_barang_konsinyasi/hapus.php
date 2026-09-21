<html>
    <head>
    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $kode = @$_GET['kode_barang_konsinyasi'];
        
        $hapus = mysqli_query($conn, "DELETE FROM barang_konsinyasi 
        WHERE kode_barang_konsinyasi = '$kode'") or die(mysqli_error($conn));

        echo '<script>alert("Data Barang Konsinyasi '.$kode.' Berhasil Dihapus");
        window.location.href="../superadmin_barang_konsinyasi"
        </script>';
        ?>
    </body>
</html>

