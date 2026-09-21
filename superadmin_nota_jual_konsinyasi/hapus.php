<html>
<head></head>
<body>
    <?php 
    require_once '../database/config.php';
    $kode_nota = @$_GET['kode_nota'];
    
    // Hapus detail nota terlebih dahulu
    $cek_detail = mysqli_query($conn, "SELECT * FROM detail_nota_jual_konsinyasi WHERE kode_nota = '$kode_nota'") 
                  or die(mysqli_error($conn));

    if (mysqli_num_rows($cek_detail) > 0) {
        // Kembalikan stok barang konsinyasi
        while ($detail = mysqli_fetch_array($cek_detail)) {
            $kode_barang = $detail['kode_barang_konsinyasi'];
            $jumlah      = $detail['jumlah'];

            mysqli_query($conn, "UPDATE barang_konsinyasi SET stok = stok + '$jumlah' WHERE kode_barang_konsinyasi = '$kode_barang'")
            or die(mysqli_error($conn));
        }
        // Hapus detail
        mysqli_query($conn, "DELETE FROM detail_nota_jual_konsinyasi WHERE kode_nota = '$kode_nota'")
        or die(mysqli_error($conn));
    }

    // Hapus header nota
    mysqli_query($conn, "DELETE FROM nota_jual_konsinyasi WHERE kode_nota = '$kode_nota'")
    or die(mysqli_error($conn));
    ?>
    <script>
        alert("Nota Jual Konsinyasi <?= $kode_nota ?> Berhasil Dihapus");
        window.location.href = "index.php";
    </script>
</body>
</html>

