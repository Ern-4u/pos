<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $kode_suplier = @$_GET['kode_suplier'];
        
        
        $hapus_suplier = mysqli_query($conn, "DELETE FROM suplier 
        WHERE kode_suplier = '$kode_suplier'")or die (mysqli_error($conn));


        echo '<script>alert("Data Pengguna '.$kode_suplier.' Berhasil Dihapus");
        window.location.href="../superadmin_suplier"
        </script>';
        ?>
    </body>
</html>