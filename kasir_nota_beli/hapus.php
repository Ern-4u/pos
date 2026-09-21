<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $kode_nota = @$_GET['kode_nota'];
        
        
        $hapus_nota_beli= mysqli_query($conn, "DELETE FROM nota_beli 
        WHERE kode_nota = '$kode_nota'")or die (mysqli_error($conn)); 
        
        $cek_detail_nota = mysqli_query($conn, "SELECT * FROM detail_nota_beli WHERE kode_nota = '$kode_nota'") or die(mysqli_error($conn));
        $rv = mysqli_num_rows($cek_detail_nota);

        if ($rv == 0) { ?>
                 <script> alert("Data Berhasil Dihapus");
                window.location.href="index.php"
                </script>
            <?php
        } else { 
            
        $hapus_detail_nota_beli = mysqli_query($conn, "DELETE FROM detail_nota_beli
        WHERE kode_nota = '$kode_nota'")or die(mysqli_error($conn))
        ?>
                <script> alert("Data Berhasil Dihapus");
                window.location.href="index.php"
                </script> 
        <?php } ?> 

       
    </body>
</html>