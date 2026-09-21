<html>
    <head>

    </head>
    <body>
        <?php 
        require_once '../database/config.php';
        $pengguna_login = $_SESSION['username'];
        $pengguna = @$_GET['user'];
        $cek_admin = mysqli_query($conn, "SELECT COUNT(*) AS jumlah
        FROM users WHERE peran='K'")or die(mysqli_error($conn));//ngecek jumlah admin
        $data = mysqli_fetch_assoc($cek_admin);
        $jumlah = $data['jumlah'];
        if ($pengguna_login == $pengguna && $jumlah == 1) {
            echo '<script>alert("Anda Tidak Dapat Menghapus Akun Diri Anda Sendiri Atau Akun Admin Tinggal 1");
            window.location.href="../superadmin_users"
            </script>';

        }elseif ($pengguna_login != $pengguna && $jumlah == 0) {
        $hapus_pengguna = mysqli_query($conn, "DELETE FROM users 
        WHERE username = '$pengguna'")or die (mysqli_error($conn));
        echo '<script>alert("Data Pengguna '.$pengguna.' Berhasil Dihapus");
        window.location.href="../superadmin_users"
        </script>';
        
        }else {
        $hapus_pengguna = mysqli_query($conn, "DELETE FROM users 
        WHERE username = '$pengguna'")or die (mysqli_error($conn));
        echo '<script>alert("Data Pengguna '.$pengguna.' Berhasil Dihapus");
        window.location.href="../superadmin_users"
        </script>';
        }
        ?>
    </body>
</html>