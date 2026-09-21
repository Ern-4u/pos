<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $id = @$_GET['id'];
        $kode_nota = @$_GET['kode_nota'];
        

        $query_ambil_data = mysqli_query($conn, "SELECT * FROM detail_nota_beli WHERE id ='$id'") or die(mysqli_error($conn));
         
        $data_detail_nota_beli = mysqli_fetch_array($query_ambil_data);
        $kode_barang = $data_detail_nota_beli['kode_barang'];

        $query_ambil_stok = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '$kode_barang'")or die(mysqli_error($conn));
         $stok = mysqli_fetch_array($query_ambil_stok);
         $total_stok =  $stok['stok'] - $data_detail_nota_beli['jumlah'];

        $query_ambil_total_pembelian = mysqli_query($conn, "SELECT total_pembelian FROM nota_beli WHERE kode_nota = '$kode_nota'")or die(mysqli_error($conn));
         $nt_beli = mysqli_fetch_array($query_ambil_total_pembelian);
         $total_harga_baru = $nt_beli['total_pembelian'] - $data_detail_nota_beli['total_harga_beli'];


        

        $query_update_stok = mysqli_query($conn, "UPDATE barang SET stok='$total_stok' WHERE kode_barang = '$kode_barang'") or die(mysqli_error($conn));
        $query_update_harga_beli = mysqli_query($conn, "UPDATE nota_beli SET total_pembelian='$total_harga_baru' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($conn));
        $hapus_detail_nota_beli= mysqli_query($conn, "DELETE FROM detail_nota_beli 
        WHERE id = '$id'")or die (mysqli_error($conn));
        

        ?>
        <script> alert("Data Berhasil Dihapus");
        window.location.href="../superadmin_detail_nota_beli/?kode_nota=<?= $kode_nota ?>"
        </script>
    </body>
</html>