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
  $hal = "superadmin_nota_jual";
  $kode_nota = @$_GET['kode_nota'];

 
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
        <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Barang Reguler</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Barang Konsinyasi</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <?php 
                  $query_barang = "SELECT detail_nota_jual.*, nota_jual.kode_nota ,barang.nama_barang
                    FROM detail_nota_jual 
                    LEFT JOIN nota_jual ON detail_nota_jual.kode_nota = nota_jual.kode_nota
                    LEFT JOIN barang ON detail_nota_jual.kode_barang = barang.kode_barang
                    where detail_nota_jual.kode_nota = '$kode_nota'";
                    $result_barang = mysqli_query($conn, $query_barang);
                    $data_detail_nota_r = mysqli_fetch_all($result_barang, MYSQLI_ASSOC);
                  ?>
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <button data-toggle="modal" data-target="#modal-tambah_br" class="btn btn-primary mb-3" type="button"><i class="fas fa-plus"></i> Tambah Data</button>
                    <a href="nota.php?id=<?= $kode_nota ?>" target="_blank" class="btn btn-info mb-3"><i class="fas fa-file-pdf"></i> Buat Nota</a>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>ID</th>
                        <th>Kode Nota</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total Harga Jual</th>
                        <th>Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                      $no = 1; 
                      foreach ($data_detail_nota_r as $sr) : ?>
                        <tr>
                          <td><?=  $no++ ; ?></td>
                          <td><?= $sr['id']; ?></td>
                          <td><?= $sr['kode_nota']; ?></td>
                          <td><?= $sr['nama_barang']; ?></td>
                          <td><?= $sr['jumlah'] ?> </td>
                          <td><?= $sr['harga_jual'] ?> </td>
                          <td><?= $sr['total_harga_jual'] ?> </td>
                          
                          
                          <td>
                            <a href="hapus.php?id=<?= $sr['id']?>&kode_nota=<?= $sr['kode_nota']?>" 
                            class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')">
                            <i class="fas fa-trash"></i></a>
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-edit" 
                            data-id="<?= $sr['id'] ?>" 
                            data-kode_nota="<?= $sr['kode_nota'] ?>" 
                            data-kode_barang="<?= $sr['kode_barang'] ?>" 
                            data-jumlah="<?= $sr['jumlah'] ?>" 
                            data-harga_jual="<?= $sr['harga_jual'] ?>" 
                            data-total_harga_jual="<?= $sr['total_harga_jual'] ?>" 
                            
                            ><i class="fas fa-edit"></i>
                            </button>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <?php 
                  $query_barang_k = "SELECT detail_nota_jual.*, nota_jual.kode_nota ,barang_konsinyasi.nama_barang
                    FROM detail_nota_jual 
                    LEFT JOIN nota_jual ON detail_nota_jual.kode_nota = nota_jual.kode_nota
                    LEFT JOIN barang_konsinyasi ON detail_nota_jual.kode_barang = barang_konsinyasi.kode_barang_konsinyasi
                    where detail_nota_jual.kode_nota = '$kode_nota'";
                    $result_barang_k = mysqli_query($conn, $query_barang_k);
                    $data_detail_nota_k = mysqli_fetch_all($result_barang_k, MYSQLI_ASSOC);
                  ?>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                     <button data-toggle="modal" data-target="#modal-tambah_bk" class="btn btn-primary mb-3" type="button"><i class="fas fa-plus"></i> Tambah Data</button>
                    <a href="nota.php?id=<?= $kode_nota ?>" target="_blank" class="btn btn-info mb-3"><i class="fas fa-file-pdf"></i> Buat Nota</a>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>ID</th>
                        <th>Kode Nota</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total Harga Jual</th>
                        <th>Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                      $no = 1; 
                      foreach ($data_detail_nota_k as $s) : ?>
                        <tr>
                          <td><?=  $no++ ; ?></td>
                          <td><?= $s['id']; ?></td>
                          <td><?= $s['kode_nota']; ?></td>
                          <td><?= $s['nama_barang']; ?></td>
                          <td><?= $s['jumlah'] ?> </td>
                          <td><?= $s['harga_jual'] ?> </td>
                          <td><?= $s['total_harga_jual'] ?> </td>
                          
                          
                          <td>
                            <a href="hapus.php?id=<?= $s['id']?>&kode_nota=<?= $s['kode_nota']?>" 
                            class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')">
                            <i class="fas fa-trash"></i></a>
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-edit" 
                            data-id="<?= $s['id'] ?>" 
                            data-kode_nota="<?= $s['kode_nota'] ?>" 
                            data-kode_barang="<?= $s['kode_barang'] ?>" 
                            data-jumlah="<?= $s['jumlah'] ?>" 
                            data-harga_jual="<?= $s['harga_jual'] ?>" 
                            data-total_harga_jual="<?= $s['total_harga_jual'] ?>" 
                            
                            ><i class="fas fa-edit"></i>
                            </button>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.card -->
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
<?php
$query_nota_jual = "SELECT * FROM nota_jual";
$result_nota_jual = mysqli_query($conn, $query_nota_jual);
$query_barang_re = "SELECT * FROM barang";
$result_barang_re = mysqli_query($conn, $query_barang_re);
$query_barang_ko = "SELECT * FROM barang_konsinyasi";
$result_barang_ko = mysqli_query($conn, $query_barang_ko);
?>



      <!-- modal Tambah -->
      <div class="modal fade" id="modal-tambah_br">
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
                    <label for="kode_nota">Nota Jual</label>
                    <input name="kode_nota" value="<?= $kode_nota ?>" class="form-control" id="kode_nota" readonly required>                   
                </div>

                <!-- Select Barang (Perbaikan Name dan ID) -->
                <div class="form-group">
                    <label for="kode_barang">Barang</label>
                    <select name="kode_barang" class="form-control" id="kode_barang" required>
                        <option value="">Pilih Barang</option>
                        <?php while($row = mysqli_fetch_assoc($result_barang)): ?>
                            <option value="<?= $row['kode_barang'] ?>"><?= $row['nama_barang'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan Jumlah Barang" required>
                </div>
                
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" placeholder="Masukan Harga Beli" required>
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
       <!-- modal Tambah -->
      <div class="modal fade" id="modal-tambah_bk">
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
                    <label for="kode_nota">Nota Jual</label>
                    <input name="kode_nota" value="<?= $kode_nota ?>" class="form-control" id="kode_nota" readonly required>                   
                </div>

                <!-- Select Barang (Perbaikan Name dan ID) -->
                <div class="form-group">
                    <label for="kode_barang">Barang</label>
                    <select name="kode_barang" class="form-control" id="kode_barang" required>
                        <option value="">Pilih Barang</option>
                        <?php while($row = mysqli_fetch_assoc($result_barang_ko)): ?>
                            <option value="<?= $row['kode_barang_konsinyasi'] ?>"><?= $row['nama_barang'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Masukan Jumlah Barang" required>
                </div>
                
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" placeholder="Masukan Harga Beli" required>
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




<!-- jQuery -->
<?php include '../script.php'; ?>
</body>



</html>
<?php
}
?>