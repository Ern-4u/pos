<?php 
require_once('../database/config.php');
?>
<html>
<head>
</head>
<body>
<?php
if (isset($_POST['btn_tambah_admin'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $nama_panggilan = trim(mysqli_real_escape_string($conn, $_POST['nama_panggilan']));
    $role = trim(mysqli_real_escape_string($conn, $_POST['peran']));
    $password = sha1($username);
    $pin2fa = '1234';

    $cek_user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username' ") 
    or die (mysqli_error($conn));
    $rv = mysqli_num_rows($cek_user);


    if ($rv == 1) {
        echo '<script> alert("Username Sudah Terdaftar! Input yang lain");
        window.location.href="../data_admin_administrator" </script>';

    } else {
        $query_simpan = mysqli_query($conn, "INSERT INTO users 
        (username,
         sandi,
         peran,
         pin2fa,
         nama_panggilan) 
         VALUES 
         ('$username', 
         '$password',
         '$role',
         '$pin2fa',
         '$nama_panggilan')
         ") or die (mysqli_error($conn)) ;

         echo '<script> alert("Data Berhasil Disimpan"); 
         window.location.href="../superadmin_users" </script>';
    }
}



?>
</body>
</html>