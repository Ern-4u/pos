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
  $hal = "superadmin_barang_konsinyasi";

  $query_suplier = mysqli_query($conn, "SELECT kode_suplier, nama_suplier FROM suplier") or die(mysqli_error($conn));

?>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
          <a href="#" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img src="../assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>SISTEM POS</b></span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>
      <?php include '../sidebar_superadmin.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"></div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Data Barang Konsinyasi</h3>
              </div>
              <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                    <label for="kode_barang_konsinyasi">Kode Barang Konsinyasi</label>
                    <input type="text" name="kode_barang_konsinyasi" class="form-control" id="kode_barang_konsinyasi" maxlength="20" placeholder="Masukan Kode Barang Konsinyasi" required>
                </div>
                <div class="form-group">
                  <label for="id_suplier">Suplier</label>
                  <select class="form-control" name="id_suplier" id="id_suplier" required>
                    <option value="">-- Pilih Suplier --</option>
                    <?php while ($row = mysqli_fetch_array($query_suplier)) { ?>
                      <option value="<?= $row['kode_suplier'] ?>"><?= $row['nama_suplier'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang" maxlength="100" placeholder="Masukan Nama Barang" required>
                </div>
                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" name="merk" class="form-control" id="merk" maxlength="50" placeholder="Masukan Merk Barang" required>
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli" min="0" placeholder="Masukan Harga Beli" required>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" min="0" placeholder="Masukan Harga Jual" required>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" min="0" placeholder="Masukan Stok" required>
                </div>
                <div class="modal-footer">
                  <a type="button" class="btn btn-default" href="index.php">Kembali</a>
                  <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
                </div>
              </form>
              </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
if (isset($_POST['btn_tambah'])) {
    $kode = trim(mysqli_real_escape_string($conn, $_POST['kode_barang_konsinyasi']));
    $id_suplier = trim(mysqli_real_escape_string($conn, $_POST['id_suplier']));
    $nama_barang = trim(mysqli_real_escape_string($conn, $_POST['nama_barang']));
    $merk = trim(mysqli_real_escape_string($conn, $_POST['merk']));
    $harga_beli = trim(mysqli_real_escape_string($conn, $_POST['harga_beli']));
    $harga_jual = trim(mysqli_real_escape_string($conn, $_POST['harga_jual']));
    $stok = trim(mysqli_real_escape_string($conn, $_POST['stok']));

    $cek = mysqli_query($conn, "SELECT kode_barang_konsinyasi FROM barang_konsinyasi WHERE kode_barang_konsinyasi = '$kode'")
    or die(mysqli_error($conn));
    $rv = mysqli_num_rows($cek);

    if ($rv > 0) {
        echo '<script> alert("Kode Barang Konsinyasi Sudah Terdaftar! Gunakan kode lain.");
        window.location.href="../superadmin_barang_konsinyasi/tambah.php" </script>';
    } else {
        $query_simpan = mysqli_query($conn, "INSERT INTO barang_konsinyasi 
        (kode_barang_konsinyasi, id_suplier, nama_barang, merk, harga_beli, harga_jual, stok)
        VALUES 
        ('$kode', '$id_suplier', '$nama_barang', '$merk', '$harga_beli', '$harga_jual', '$stok')")
        or die(mysqli_error($conn));

        if ($query_simpan) {
            echo '<script> alert("Data Berhasil Disimpan"); 
            window.location.href="../superadmin_barang_konsinyasi" </script>';
        } else {
            echo '<script> alert("Data Gagal Disimpan"); 
            window.location.href="../superadmin_barang_konsinyasi/tambah.php" </script>';
        }
    }
}
?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- Main Footer -->
  <?php include '../footer.php'; ?>
</div>
<!-- ./wrapper -->

<?php include '../script.php'; ?>
</body>
</html>
<?php
}
?>

