

<?php
require_once '../database/config.php';


if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_suplier = trim(mysqli_real_escape_string($conn, $_POST['kode_suplier']));
    $tgl_penjualan = trim(mysqli_real_escape_string($conn, $_POST['tgl_penjualan']));
    $status = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($conn, $_POST['keterangan']));
    $total_penjualan = trim(mysqli_real_escape_string($conn, $_POST['total_penjualan']));

    $cek_kode_nota= mysqli_query($conn, "SELECT kode_nota FROM nota_jual WHERE kode_nota = '$kode_nota' ") 
    or die (mysqli_error($conn));
    $rv = mysqli_num_rows($cek_kode_nota);

        if ($rv > 0 ) {
            echo '<script> alert("Kode Nota Sudah Terdaftar! Input yang lain");
            window.location.href="index.php" </script>';

        } else {
            $query_simpan = mysqli_query($conn, "INSERT INTO nota_jual
            (
            kode_nota,
            kode_suplier,
            tgl_penjualan,
            status,
            keterangan,
            total_penjualan
            )
            VALUES 
            ('$kode_nota',
            '$kode_suplier',
            '$tgl_penjualan',
            '$status',
            '$keterangan',
            '$total_penjualan'
            )
            ") or die (mysqli_error($conn)) ;

            echo '<script> alert("Data Berhasil Disimpan"); 
            window.location.href="index.php" </script>';
        }
    
}



?>