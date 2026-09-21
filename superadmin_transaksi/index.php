<?php 
require_once '../database/config.php';
$authority = @$_SESSION['peran'];

if ($authority != 'S') {
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
  $hal = "superadmin_transaksi";
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
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php
          $nama = $_SESSION['nama_panggilan'];
          echo $nama;
          ?>
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <a href="../logout.php" class="dropdown-item">
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
      <span class="brand-text font-weight-light"><b>POS</b>
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
          <a href="#" class="d-block">Dashboard <b>SuperAdmin</b>
          </a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <?php include '../sidebar_superadmin.php'; ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       
      <div class="row">
        <div class="col-9">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> Transaksi Penjualan</h3>
              </div>
              <div class="card-body">
                <div class="row">
                <?php
                $query_barang = mysqli_query($conn, "SELECT * FROM barang")or die(mysqli_error($conn));

                while ($barang =mysqli_fetch_array($query_barang)) { ?>
                  <div class="col-3">
                    <div class="card">
                      <div class="card-header" style="display: flex; justify-content: center; align-items: center;">
                        <h5 class="card-title" ><?= $barang['nama_barang'] ?></h5>
                      </div>
                      <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                        <?php 
                        if ( $barang['foto_barang'] == null ) { ?>
                        <img src="../assets/foto_barang/fto_barang.png" alt="" width="150" height="150px">
                       <?php } else {
                        ?>
                        <img src="../assets/foto_barang/<?= $barang['foto_barang'] ?>" width="150px" height="150px" alt="">
                        <?php }
                          ?>
                      </div>
                      <div class="card-footer">
                        <span>Stok : <?= $barang['stok'] ?></span>
                        <button class="btn btn-warning btn-xs"><i class="bi bi-bag-check-fill"></i> Masukan Keranjang</button>
                      </div>
                    </div>
                  </div>

                <?php }
                ?>
              </div>
              </div>
              </div>

        </div>
        <div class="col-3">
            <div class="card card-white">
              <div class="card-body">
                
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