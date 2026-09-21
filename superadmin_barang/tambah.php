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
  $hal = "superadmin_barang";

 

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

    <?php 
    $query_ambil_suplier = mysqli_query($conn, "SELECT kode_suplier,nama_suplier FROM suplier") or die(mysqli_error($conn));
   

    ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Data Barang</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" maxlength="10" placeholder="Masukan Kode Barang" required>
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang" maxlength="20" placeholder="Masukan Nama Barang" required>
                </div>
                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" name="merk" class="form-control" id="merk" maxlength="15" placeholder="Masukan Merk barang" required>
                </div>
                <div class="form-group">
                  <label for="kode_suplier">Suplier</label>
                  <select class="form-control" name="kode_suplier" id="kode_suplier" required>
                    <option value="">--Masukan Suplier--</option>
                    <?php while ($data_suplier = mysqli_fetch_array($query_ambil_suplier)) { ?>
                      <option value="<?=$data_suplier['kode_suplier'] ?>"> <?=$data_suplier['nama_suplier'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                    <label for="rata_harga_beli">Harga Beli</label>
                    <input type="number" name="rata_harga_beli" class="form-control" id="rata_harga_beli"  placeholder="Masukan Harga Beli Barang" required>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual"  placeholder="Masukan Harga Jual Barang" required>
                </div>
                <div class="modal-footer">
                <a type="button" class="btn btn-default" href="index.php">Kembali</a>
                <button type="submit" name="btn_tambah_barang" class="btn btn-primary">Simpan</button>
              </div>
              </form>
              </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->

        
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
if (isset($_POST['btn_tambah_barang'])) {
    $kode_barang = trim(mysqli_real_escape_string($conn, $_POST['kode_barang']));
    $nama_barang = trim(mysqli_real_escape_string($conn, $_POST['nama_barang']));
    $merk = trim(mysqli_real_escape_string($conn, $_POST['merk']));
    $kode_suplier = trim(mysqli_real_escape_string($conn, $_POST['kode_suplier']));
    $stok = 0 ;
    $rata_harga_beli = trim(mysqli_real_escape_string($conn, $_POST['rata_harga_beli']));
    $harga_jual = trim(mysqli_real_escape_string($conn, $_POST['harga_jual']));

    $cek_kode_barang = mysqli_query($conn, "SELECT kode_barang FROM barang WHERE kode_barang = '$kode_barang' ") 
    or die (mysqli_error($conn));
    $rv = mysqli_num_rows($cek_kode_barang);

        if ($rv > 0 ) {
            echo '<script> alert("Kode Barang Sudah Terdaftar! Input yang lain");
            window.location.href="../superadmin_barang" </script>';

        } else {
            $query_simpan = mysqli_query($conn, "INSERT INTO barang 
            (
            kode_barang,
            kode_suplier,
            nama_barang,
            merk,
            stok,
            rata_harga_beli,
            harga_jual
            )
            VALUES 
            ('$kode_barang',
            '$kode_suplier',
            '$nama_barang',
            '$merk',
            '$stok',
            '$rata_harga_beli',
            '$harga_jual')
            ") or die (mysqli_error($conn)) ;


            echo '<script> alert("Data Berhasil Disimpan"); 
            window.location.href="../superadmin_barang" </script>';
        }
    
}



?>


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