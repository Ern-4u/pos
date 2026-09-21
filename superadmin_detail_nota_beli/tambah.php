

<?php
require_once '../database/config.php';


if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_barang = trim(mysqli_real_escape_string($conn, $_POST['kode_barang']));
    $jumlah = trim(mysqli_real_escape_string($conn, $_POST['jumlah']));
    $harga_beli = trim(mysqli_real_escape_string($conn, $_POST['harga_beli']));
    $total_harga_beli = $jumlah * $harga_beli;

    $query_stok = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='$kode_barang'") or die(mysqli_error($conn));
    $stok = mysqli_fetch_array($query_stok);

    $total_stok = $jumlah + $stok['stok'];

    $query_total_harga = mysqli_query($conn, "SELECT total_pembelian FROM nota_beli WHERE kode_nota='$kode_nota'") or die(mysqli_error($conn));
    $total_transaksi_lama = mysqli_fetch_array($query_total_harga);

    $total_transaksi_baru = $total_transaksi_lama['total_pembelian'] + $total_harga_beli;
    
            $query_simpan = mysqli_query($conn, "INSERT INTO detail_nota_beli 
            (
            kode_nota,
            kode_barang,
            jumlah,
            harga_beli,
            total_harga_beli
            )
            VALUES 
            ('$kode_nota',
            '$kode_barang',
            '$jumlah',
            '$harga_beli',
            '$total_harga_beli'
            )
            ") or die (mysqli_error($conn)) ;

            $query_update = mysqli_query($conn, "UPDATE barang SET stok = '$total_stok' WHERE kode_barang= '$kode_barang'")
            or die(mysqli_error($conn));

            $query_update = mysqli_query($conn, "UPDATE nota_beli SET total_pembelian = '$total_transaksi_baru' WHERE kode_nota= '$kode_nota'")
            or die(mysqli_error($conn));

            if ($query_simpan){
            ?> <script> alert("Data Berhasil Di Tambah"); 
            window.location.href="../superadmin_detail_nota_beli/?kode_nota=<?= $kode_nota ?>" </script> <?php ;
            } else {
              ?> <script> alert("Data Gagal Di Tambah"); 
            window.location.href="../superadmin_detail_nota_beli/?kode_nota=<?= $kode_nota ?> " </script> <?php ;
            }
}



?>