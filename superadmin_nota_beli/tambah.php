

<?php
require_once '../database/config.php';


if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_suplier = trim(mysqli_real_escape_string($conn, $_POST['kode_suplier']));
    $tgl_pembelian = trim(mysqli_real_escape_string($conn, $_POST['tgl_pembelian']));
    $status = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($conn, $_POST['keterangan']));
    $total_pembelian = 0 ;

    $cek_kode_nota= mysqli_query($conn, "SELECT kode_nota FROM nota_beli WHERE kode_nota = '$kode_nota' ") 
    or die (mysqli_error($conn));
    $rv = mysqli_num_rows($cek_kode_nota);

        if ($rv > 0 ) {
            echo '<script> alert("Kode Nota Sudah Terdaftar! Input yang lain");
            window.location.href="../superadmin_nota_beli" </script>';

        } else {
            $query_simpan = mysqli_query($conn, "INSERT INTO nota_beli 
            (
            kode_nota,
            kode_suplier,
            tgl_pembelian,
            status,
            keterangan,
            total_pembelian
            )
            VALUES 
            ('$kode_nota',
            '$kode_suplier',
            '$tgl_pembelian',
            '$status',
            '$keterangan',
            '$total_pembelian'
            )
            ") or die (mysqli_error($conn)) ;

            echo '<script> alert("Data Berhasil Disimpan"); 
            window.location.href="../superadmin_nota_beli" </script>';
        }
    
}



?>