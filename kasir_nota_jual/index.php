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
  $hal = "superadmin_nota_jual";

  $query = "SELECT nota_jual.*, suplier.nama_suplier 
            FROM nota_jual 
            LEFT JOIN suplier ON nota_jual.kode_suplier = suplier.kode_suplier";
  $result = mysqli_query($conn, $query);
  $data_nota = mysqli_fetch_all($result, MYSQLI_ASSOC);
 
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
                <h3 class="card-title">Data Nota Jual</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button href="tambah.php" data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary mb-3" type="button"><i class="fas fa-plus"></i> Tambah Data</button>
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode Nota</th>
                    <th>Suplier</th>
                    <th>Tanggal Jual</th>
                    <th>Total Penjualan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Jns Pembayaran</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                  $no = 1; 
                  foreach ($data_nota as $s) : ?>
                    <tr>
                      <td><?=  $no++ ; ?></td>
                      <td><?= $s['kode_nota']; ?></td>
                      <td><?= $s['nama_suplier']; ?></td>
                      <td><?= $s['tgl_penjualan'] ?> </td>
                      <td><?= $s['total_penjualan'] ?> </td>
                      <td>
                      <?php
                      if ($s['status'] == 'L') {
                        echo "Lunas";
                      } elseif ($s['status'] == '2') {
                        echo "Dibayar 25%";
                      } elseif ($s['status'] == '3') {
                        echo "Dibayar 50%";
                      } elseif ($s['status'] == '4') {
                        echo "Dibayar 75%";
                      } else {
                        echo "Belum Dibayar";
                      }
                      ?> 
                      </td>
                      <td><?= $s['keterangan'] ?> </td>
                      <td><?= $s['jenis_pembayaran'] ?></td>
                      <td>
                        <a href="../kasir_detail_nota_jual/?kode_nota=<?=$s['kode_nota'] ?>" class="btn btn-success btn-xs">
                          <i class="fas fa-eye"></i></a>
                        </a>
                        <a href="hapus.php?kode_nota=<?= $s['kode_nota']; ?>" 
                        class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')">
                        <i class="fas fa-trash"></i></a>
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-edit" data-kode_nota="<?= $s['kode_nota'] ?>" data-kode_suplier="<?= $s['kode_suplier'] ?>" data-tgl_penjualan="<?= $s['tgl_penjualan'] ?>" data-total_penjualan="<?= $s['total_penjualan'] ?>" data-status="<?= $s['status'] ?>" data-keterangan="<?= $s['keterangan'] ?>">
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>
                    </tr>
                     <?php endforeach; ?>
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
$query_suplier = "SELECT * FROM suplier";
$result_suplier = mysqli_query($conn, $query_suplier);
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
                <div class="form-group">
                    <label for="kode_nota">Kode Nota</label>
                    <input type="number" name="kode_nota" class="form-control" id="kode_nota" placeholder="Masukan Kode Nota" required>
                </div>
                <div class="form-group">
                    <label for="kode_suplier">Suplier</label>
                    <select name="kode_suplier" class="form-control" id="kode_suplier" required>
                        <option value="">Pilih Suplier</option>
                        <?php while($row = mysqli_fetch_assoc($result_suplier)): ?>
                            <option value="<?= $row['kode_suplier'] ?>"><?= $row['nama_suplier'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_penjualan">Total Penjualan</label>
                    <input type="number" name="total_penjualan" class="form-control" id="total_penjualan" placeholder="Masukan Total Nota" required>
                </div>
                <div class="form-group">
                    <label for="tgl_penjualan">Tanggal Pembelian</label>
                    <input type="date" name="tgl_penjualan" class="form-control" id="tgl_penjualan" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                   <select name="status" class="form-control" id="status" required>
                        <option value="">Pilih Status</option>
                        <option value="L">Lunas</option>
                        <option value="2">Dibayar 25%</option>
                        <option value="3">Dibayar 50%</option>
                        <option value="4">Dibayar 75%</option>
                    </select>
                </div>
                <div class="form-group"></div>
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan Keterangan">
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
              </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Tambah -->

<!-- modal Edit -->
      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Nota Beli</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit.php" method="post">
                <div class="form-group">
                    <label for="kode_nota">Kode Nota</label>
                    <input type="number" name="kode_nota" class="form-control" id="kode_nota" placeholder="Masukan Kode Nota" readonly required>
                </div>
                <div class="form-group">
                    <label for="kode_suplier">Suplier</label>
                    <select name="kode_suplier" class="form-control" id="kode_suplier" required>
                        <option value="">Pilih Suplier</option>
                        <?php mysqli_data_seek($result_suplier, 0);
                        while($row = mysqli_fetch_assoc($result_suplier)): ?>
                            <option value="<?= $row['kode_suplier'] ?>"><?= $row['nama_suplier'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_penjualan">Total Nota</label>
                    <input type="number" name="total_penjualan" class="form-control" id="total_penjualan" placeholder="Masukan Total Nota" required>
                </div>
                <div class="form-group">
                    <label for="tgl_penjualan">Tanggal Penjalan</label>
                    <input type="date" name="tgl_penjualan" class="form-control" id="tgl_penjualan" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                   <select name="status" class="form-control" id="status" required>
                        <option value="">Pilih Status</option>
                        <option value="L">Lunas</option>
                        <option value="2">Dibayar 25%</option>
                        <option value="3">Dibayar 50%</option>
                        <option value="4">Dibayar 75%</option>
                    </select>
                </div>
                <div class="form-group"></div>
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan Keterangan">
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_edit" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Edit -->



<!-- jQuery -->
<?php include '../script.php'; ?>
</body>

<script type="text/javascript">
   $('#modal-edit').on('show.bs.modal', function(e) {

   var kode_nota = $(e.relatedTarget).data('kode_nota');
   var kode_suplier = $(e.relatedTarget).data('kode_suplier');
   var total_penjualan = $(e.relatedTarget).data('total_penjualan');
   var tgl_penjualan = $(e.relatedTarget).data('tgl_penjualan');
   var status = $(e.relatedTarget).data('status');
   var keterangan = $(e.relatedTarget).data('keterangan');

 

  $(e.currentTarget).find('input[name="kode_nota"]').val(kode_nota);
  $(e.currentTarget).find('select[name="kode_suplier"]').val(kode_suplier);
  $(e.currentTarget).find('input[name="total_penjualan"]').val(total_penjualan);
  $(e.currentTarget).find('input[name="tgl_penjualan"]').val(tgl_penjualan);
  $(e.currentTarget).find('select[name="status"]').val(status);
  $(e.currentTarget).find('input[name="keterangan"]').val(keterangan);
   
   });
 
</script> 


</html>
<?php
}
?>