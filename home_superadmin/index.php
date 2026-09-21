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
  $hal = "beranda_superadmin";
  require_once '../database/config.php';

  
  $query_total_penjualan = mysqli_query($conn, "SELECT SUM(total_penjualan) AS total_penjualan FROM nota_jual") or die(mysqli_error($conn));
  $total_penjualan = mysqli_fetch_array($query_total_penjualan);

  $query_total_pembelian = mysqli_query($conn, "SELECT SUM(total_pembelian) AS total_pembelian FROM nota_beli") or die(mysqli_error($conn));
  $total_pembelian = mysqli_fetch_array($query_total_pembelian);

  $laba = $total_penjualan['total_penjualan'] - $total_pembelian['total_pembelian'];

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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rp.<?= $total_penjualan['total_penjualan'] ?></h3>

                <p>Total Penjualan</p>
              </div>
              <div class="icon">
                <i class="bi bi-cash-coin"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Rp.<?= $total_pembelian['total_pembelian'] ?></h3>

                <p>Total Pendapatan</p>
              </div>
              <div class="icon">
                <i class="bi bi-cash-coin"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
             <?php 
             if ($laba < 0) { ?>
              <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp.<?= $laba ?></h3>

                <p>Total Laba</p>
              </div>
              <div class="icon">
                <i class="bi bi-cash-coin"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
             <?php 
             } else { ?>
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rp.<?= $laba ?></h3>

                <p>Total Laba</p>
              </div>
              <div class="icon">
                <i class="bi bi-cash-coin"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <?php } ?>
            
          </div>
        </div>
        <!-- /.row -->

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