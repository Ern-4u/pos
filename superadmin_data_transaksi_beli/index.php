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
  $hal = "data_transaksi_beli";
  require_once '../database/config.php';
  ?>
</head>
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
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Dashboard <b>SuperAdmin</b></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <?php include '../sidebar_superadmin.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Transaksi Beli</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <div class="card">
              <div class="card-header">
                <form method="GET" action="">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Tanggal Mulai</label>
                      <input type="date" name="tgl_mulai" class="form-control" value="<?= isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '' ?>">
                    </div>
                    <div class="col-md-4">
                      <label>Tanggal Selesai</label>
                      <input type="date" name="tgl_selesai" class="form-control" value="<?= isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '' ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                      <button type="submit" class="btn btn-primary mr-2">Filter</button>
                      <a href="index.php" class="btn btn-secondary">Reset</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Nota</th>
                    <th>Tanggal Pembelian</th>
                    <th>Supplier</th>
                    <th>Total Pembelian</th>
                    <th>Status</th>
                    <th>Kas Keluar</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $where = "";
                    if (isset($_GET['tgl_mulai']) && isset($_GET['tgl_selesai']) && $_GET['tgl_mulai'] != '' && $_GET['tgl_selesai'] != '') {
                      $tgl_mulai = mysqli_real_escape_string($conn, $_GET['tgl_mulai']);
                      $tgl_selesai = mysqli_real_escape_string($conn, $_GET['tgl_selesai']);
                      $where = " WHERE tgl_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                    }

                    // Join with suplier table to get supplier name
                    $query = "SELECT nb.*, s.nama_suplier FROM nota_beli nb LEFT JOIN suplier s ON nb.kode_suplier = s.kode_suplier $where ORDER BY nb.tgl_pembelian DESC, nb.kode_nota DESC";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= htmlspecialchars($row['kode_nota']) ?></td>
                              <td><?= htmlspecialchars($row['tgl_pembelian']) ?></td>
                              <td><?= htmlspecialchars($row['nama_suplier'] ? $row['nama_suplier'] : $row['kode_suplier']) ?></td>
                              <td>Rp <?= number_format($row['total_pembelian'], 0, ',', '.') ?></td>
                              <td><?= htmlspecialchars($row['status']) ?></td>
                              <td>
                                <?php
                                if ($row['status'] == 'L') {
                                 echo 'Rp '.number_format($row['total_pembelian'], 0, ',', '.');
                                } elseif ($row['status'] == '2') {
                                  $cash = $row['total_pembelian'] * 25 / 100 ;
                                  echo 'Rp '.number_format($cash , 0, ',', '.');
                                } elseif ($row['status'] == '3') {
                                  $cash = $row['total_pembelian'] * 50 / 100 ;
                                  echo 'Rp '.number_format($cash , 0, ',', '.');
                                } elseif ($row['status'] == '4') {
                                  $cash = $row['total_pembelian'] * 75 / 100 ;
                                  echo 'Rp '.number_format($cash , 0, ',', '.');
                                }
                                ?>
                              </td>
                              <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <?php include '../footer.php'; ?>
</div>

<?php include '../script.php'; ?>
</body>
</html>
<?php
}
?>

