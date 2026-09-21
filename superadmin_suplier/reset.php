<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        
        
        $reset_data_dosen = mysqli_query($conn, "TRUNCATE TABLE mahasiswa")or die (mysqli_error($conn));

        $hapus_data_pengguna = mysqli_query($conn, "DELETE FROM users WHERE peran = 'M'") or die(mysqli_error($conn));

        echo '<script>alert("Data Mahasiswa Berhasil Diriset");
        window.location.href="../data_mahasiswa"
        </script>';
        ?>
    </body>
</html>