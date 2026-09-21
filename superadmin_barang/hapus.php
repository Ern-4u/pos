<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $kode_barang = @$_GET['kode_barang'];
        
        
        $hapus_barang = mysqli_query($conn, "DELETE FROM barang 
        WHERE kode_barang = '$kode_barang'")or die (mysqli_error($conn));


        echo '<script>alert("Data Barang '.$kode_barang.' Berhasil Dihapus");
        window.location.href="../superadmin_barang"
        </script>';
        ?>
    </body>
</html>