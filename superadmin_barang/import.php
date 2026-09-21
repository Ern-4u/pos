<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

require_once '../assets/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/config.php';

if (isset($_POST['btn_import'])) {
    $file = $_FILES['file_excel']['name'];
    $ekstensi = explode('.', $file);
    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);

    $alamat_tujuan = 'template/'.$nama_file;
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];

    move_uploaded_file($file_alamat_sumber, $alamat_tujuan);
    $file_excel = PHPExcel_IOFactory::load($alamat_tujuan);

    $data_excel = $file_excel->getActiveSheet()->toArray(null,true,true,true);
    for ($i=2; $i<= count($data_excel); $i++) {
        $nim = $data_excel[$i]['B'];
        $nama = $data_excel[$i]['C'];
        $kontak = $data_excel[$i]['D'];
        $email = $data_excel[$i]['E'];
        $kelamin = $data_excel[$i]['F'];

        $sandi= sha1($nim);
        $peran= 'M';
        $pin = 2222;

        if (empty($nim) || empty($nama) ||empty($kontak) ||empty($email) || empty($kelamin)) {
            continue;
        } else {
            $query_cek = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'")or die(mysqli_error($conn));
            $query_cek_user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$nim'")or die(mysqli_error($conn));

            if (mysqli_num_rows($query_cek) == 0 && mysqli_num_rows($query_cek_user)== 0) {
                $query_insert = mysqli_query($conn, "INSERT INTO mahasiswa VALUES ('$nim','$nama','$kontak','$email','$kelamin')")or die(mysqli_error($conn));
                $query_insert_user = mysqli_query($conn, "INSERT INTO users (username , sandi , peran , pin , nama) VALUES ('$nim','$sandi','$peran','$pin','$nama')")or die(mysqli_error($conn));

                echo '<script>alert("Data Mahasiswa Berhasil Diimport");
                window.location.href="../data_mahasiswa"
                </script>';
            } else {
                echo '<script>alert("Data gagal di import!!!! Terdapat data Double");
                window.location.href="../data_mahasiswa"
                </script>';
            }
        }  
    }


}

?>