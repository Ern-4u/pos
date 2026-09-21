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
  $hal = "superadmin_nota_beli";
  $kode_nota = @$_GET['kode_nota'];

  $query = "SELECT detail_nota_beli.*, nota_beli.kode_nota ,barang.nama_barang
            FROM detail_nota_beli 
            LEFT JOIN nota_beli ON detail_nota_beli.kode_nota = nota_beli.kode_nota
            LEFT JOIN barang ON detail_nota_beli.kode_barang = barang.kode_barang
            where detail_nota_beli.kode_nota = '$kode_nota'";
  $result = mysqli_query($conn, $query);
  
 
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

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Nota Beli</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary mb-3" type="button"><i class="fas fa-plus"></i> Tambah Data</button>
                <a href="nota.php?kode_nota=<?= $kode_nota ?>" target="_blank" class="btn btn-info mb-3"><i class="fas fa-file-pdf"></i> Buat Nota</a>
                <a href="nota_58.php?kode_nota=<?= $kode_nota ?>" target="_blank" class="btn btn-warning mb-3"><i class="fas fa-file-pdf"></i> Buat Nota</a>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>ID</th>
                    <th>Kode Nota</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga_beli</th>
                    <th>Total Harga Beli</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                  $no = 1; 
                  while ($s = mysqli_fetch_array($result)) { ?>
                    <tr>
                      <td><?=  $no++ ; ?></td>
                      <td><?= $s['id']; ?></td>
                      <td><?= $s['kode_nota']; ?></td>
                      <td><?= $s['nama_barang']; ?></td>
                      <td><?= $s['jumlah'] ?> </td>
                      <td><?= $s['harga_beli'] ?> </td>
                      <td><?= $s['total_harga_beli'] ?> </td>
                      
                      <td>
                        <a href="hapus.php?id=<?= $s['id']?>&kode_nota=<?= $s['kode_nota']?>" 
                        class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')">
                        <i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                     <?php }?>
                  </tbody>
                </table>
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
$query_ambil_data_nota_beli = mysqli_query($conn, "SELECT kode_suplier FROM nota_beli WHERE kode_nota = '$kode_nota'")or die(mysqli_error($conn));
$dt_idsup = mysqli_fetch_array($query_ambil_data_nota_beli);
$b_id_suplier = $dt_idsup['kode_suplier'];
$result_barang = mysqli_query($conn, "SELECT * FROM barang WHERE kode_suplier = '$b_id_suplier'") or die(mysqli_error($conn));

?>



      <!-- modal Tambah -->
      <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Nota Beli</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambah.php" method="post">
                
                <!-- Select Nota -->
                 <div class="form-group">
                    <label for="kode_nota">Nota Beli</label>
                    <input name="kode_nota" value="<?= $kode_nota ?>" class="form-control" id="kode_nota" readonly required>                   
                </div>

                <!-- Select Barang (Perbaikan Name dan ID) -->
                <div class="form-group">
                    <label for="kode_barang">Barang</label>
                    <select name="kode_barang" class="form-control" id="kode_barang" required>
                        <option value="">Pilih Barang</option>
                        <?php while($row = mysqli_fetch_array($result_barang)){ ?>
                            <option value="<?= $row['kode_barang'] ?>"><?= $row['nama_barang'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan Jumlah Barang" required>
                </div>
                
                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli" placeholder="Masukan Harga Beli" required>
                </div>
                
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Tambah -->


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