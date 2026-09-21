<?php 
require_once '../database/config.php';
$authority = @$_SESSION['peran'];

if ($authority != 'K') {
  echo '<script> alert("Anda Tidak boleh masuk ke halaman ini!!!!");
  window.location.href="../logout.php" </script>';
}

else {


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../css.php'; 
  $hal = "kasir_ganti_password";
  require_once '../database/config.php';

  ?>

  
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>SISTEM POS</b>
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <?php include '../sidebar_kasir.php'; ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lock"></i> Ganti Password</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                    <div class="form-group">
                        <label for="password_lama">Password lama</label>
                        <?php 
                        $pengguna = @$_SESSION['username'];
                        ?>
                        <input type="text" value="<?= $pengguna; ?>" name="pengguna" class="form-control" hidden>
                        <input type="password" name="password_lama" class="form-control" placeholder="Input Password Lama" required>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" maxlength="15" placeholder="Input Password Baru Max 10 Char" required>
                    </div>
                    <div class="form-group">
                        <label for="pin2fa">PIN</label>
                        <input type="number" name="pin2fa" class="form-control" maxlength="15" placeholder="Input Pin Anda" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btn_edit" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Edit</button>
                    </div>
                    </form>
                    <?php
                        if (isset($_POST['btn_edit'])) { //Trigger button Edit ketika ditekan
                            $pengguna = trim(mysqli_escape_string($conn, $_POST['pengguna'])); //menyimpan value pengguna pada variabel lokal pengguna 
                            $query_pengguna = mysqli_query($conn, "SELECT sandi,pin2fa FROM users WHERE username = '$pengguna'") or die(mysqli_error($conn)); //query untuk memanggil pin dan sandi dari tabel pengguna
                            $arr = mysqli_fetch_assoc($query_pengguna); //mendefinisikan variabel $arr dari query
                            $sandi = $arr['sandi']; //menampung value sandi pada array kedalam variabel $sandi
                            $pin2fa = $arr['pin2fa']; //menampung value pin pada array kedalam variabel $pin

                            $inputan_sandi = sha1(trim(mysqli_real_escape_string($conn, $_POST['password_lama']))); ////menyimpan value inputan sandi lama dari user pada variabel lokal $inputan_sandi 
                            $inputan_sandi_baru = sha1(trim(mysqli_real_escape_string($conn, $_POST['password_baru']))); //menyimpan value inputan sandi baru dari user pada variabel lokal $inputan_sandi_baru 
                            $inputan_pin2fa = trim(mysqli_real_escape_string($conn, $_POST['pin2fa'])); //menyimpan value inputan pin dari user pada variabel lokal $pin 

                            if ($inputan_sandi == $sandi && $inputan_pin2fa == $pin2fa) { //membuat sebuah kondisi inputan sandi dan pin sama dengan sandi dan pin yang ada didalam database 
                                $query_update= mysqli_query($conn, "UPDATE users SET sandi = '$inputan_sandi_baru' WHERE username = '$pengguna'") or die(mysqli_error($conn)); //query untuk update sandi
                                echo '<script> alert("Password berhasil di update!!!") </script>';
                                echo '<script> window.location.href="../kasir_ganti_password" </script>';
                            } else {
                                echo '<script> alert("Password atau Pin salah!!!!") </script>';
                                echo '<script> window.location.href="../kasir_ganti_password" </script>';
                            }
                        }

                    ?>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include '../footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php include '../script.php'; ?>
</body>
</html>
<?php
}
?>