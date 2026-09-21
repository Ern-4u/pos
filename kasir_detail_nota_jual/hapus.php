<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $id = @$_GET['id'];
        $kode_nota = @$_GET['kode_nota'];
        

        $query_ambil_data = mysqli_query($conn, "SELECT * FROM detail_nota_jual WHERE id ='$id'") or die(mysqli_error($conn));
         
        $data_detail_nota_jual = mysqli_fetch_array($query_ambil_data);
        $kode_barang = $data_detail_nota_jual['kode_barang'];

        $query_ambil_stok = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '$kode_barang'")or die(mysqli_error($conn));
         $stok = mysqli_fetch_array($query_ambil_stok);
         $total_stok =  $stok['stok'] + $data_detail_nota_jual['jumlah'];

        $query_ambil_total_penjualan = mysqli_query($conn, "SELECT total_penjualan FROM nota_jual WHERE kode_nota = '$kode_nota'")or die(mysqli_error($conn));
         $nt_jual = mysqli_fetch_array($query_ambil_total_penjualan);
         $total_harga_baru = $nt_jual['total_penjualan'] - $data_detail_nota_jual['total_harga_jual'];


        

        $query_update_stok = mysqli_query($conn, "UPDATE barang SET stok='$total_stok' WHERE kode_barang = '$kode_barang'") or die(mysqli_error($conn));
        $query_update_harga_jual = mysqli_query($conn, "UPDATE nota_jual SET total_penjualan ='$total_harga_baru' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($conn));
        $hapus_detail_nota_jual= mysqli_query($conn, "DELETE FROM detail_nota_jual 
        WHERE id = '$id'")or die (mysqli_error($conn));
        
        
        ?>
        <script> alert("Data Berhasil Dihapus");
        window.location.href="index.php?kode_nota=<?= $kode_nota ?>"
        </script>
        
    </body>
</html>