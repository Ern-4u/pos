<html>
<head></head>
<body>
    <?php
    require_once '../database/config.php';
    $id        = @$_GET['id'];
    $kode_nota = @$_GET['kode_nota'];

    // Ambil data detail
    $q_detail = mysqli_query($conn, "SELECT * FROM detail_nota_jual_konsinyasi WHERE id = '$id'")
                or die(mysqli_error($conn));
    $detail = mysqli_fetch_assoc($q_detail);

    if ($detail) {
        $kode_barang  = $detail['kode_barang_konsinyasi'];
        $jumlah       = $detail['jumlah'];
        $total_item   = $detail['total_harga_jual'];

        // Kembalikan stok barang konsinyasi
        mysqli_query($conn, "UPDATE barang_konsinyasi SET stok = stok + '$jumlah' WHERE kode_barang_konsinyasi = '$kode_barang'")
        or die(mysqli_error($conn));

        // Kurangi total penjualan di header
        mysqli_query($conn, "UPDATE nota_jual_konsinyasi SET total_penjualan = total_penjualan - '$total_item' WHERE kode_nota = '$kode_nota'")
        or die(mysqli_error($conn));

        // Hapus item detail
        mysqli_query($conn, "DELETE FROM detail_nota_jual_konsinyasi WHERE id = '$id'")
        or die(mysqli_error($conn));
    }
    ?>
    <script>
        alert("Item Berhasil Dihapus");
        window.location.href = "../superadmin_detail_nota_jual_konsinyasi/?kode_nota=<?= $kode_nota ?>";
    </script>
</body>
</html>

