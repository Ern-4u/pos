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
  $hal = "superadmin_nota_jual_konsinyasi";

  $query = "SELECT njk.*, s.nama_suplier 
            FROM nota_jual_konsinyasi njk
            LEFT JOIN suplier s ON njk.id_suplier = s.kode_suplier
            ORDER BY njk.tgl_penjualan DESC";
  $result = mysqli_query($conn, $query);
  $data_nota = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i></a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
          <a href="#" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </li>
    </ul>
  </nav>

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
            <h3 class="card-title">Data Nota Jual Konsinyasi</h3>
          </div>
          <div class="card-body">
            <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary mb-3" type="button">
              <i class="fas fa-plus"></i> Tambah Data
            </button>
            
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
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; 
                foreach ($data_nota as $s) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s['kode_nota'] ?></td>
                    <td><?= $s['nama_suplier'] ?></td>
                    <td><?= $s['tgl_penjualan'] ?></td>
                    <td>Rp <?= number_format($s['total_penjualan'], 0, ',', '.') ?></td>
                    <td>
                      <?php
                      if ($s['status'] == 'L') {
                        echo '<span class="badge badge-success">Lunas</span>';
                      } elseif ($s['status'] == '2') {
                        echo '<span class="badge badge-warning">Dibayar 25%</span>';
                      } elseif ($s['status'] == '3') {
                        echo '<span class="badge badge-warning">Dibayar 50%</span>';
                      } elseif ($s['status'] == '4') {
                        echo '<span class="badge badge-warning">Dibayar 75%</span>';
                      } else {
                        echo '<span class="badge badge-danger">Belum Dibayar</span>';
                      }
                      ?>
                    </td>
                    <td><?= $s['keterangan'] ?></td>
                    <td>
                      <a href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=<?= $s['kode_nota'] ?>" class="btn btn-success btn-xs">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="hapus.php?kode_nota=<?= $s['kode_nota'] ?>" 
                         class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus nota ini?')">
                        <i class="fas fa-trash"></i>
                      </a>
                      <button class="btn btn-warning btn-xs" 
                        data-toggle="modal" data-target="#modal-edit"
                        data-kode_nota="<?= $s['kode_nota'] ?>"
                        data-id_suplier="<?= $s['id_suplier'] ?>"
                        data-tgl_penjualan="<?= $s['tgl_penjualan'] ?>"
                        data-total_penjualan="<?= $s['total_penjualan'] ?>"
                        data-status="<?= $s['status'] ?>"
                        data-keterangan="<?= $s['keterangan'] ?>">
                        <i class="fas fa-edit"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <aside class="control-sidebar control-sidebar-dark"></aside>
  <?php include '../footer.php'; ?>
</div>
<!-- ./wrapper -->

<?php
$query_suplier = "SELECT * FROM suplier";
$result_suplier = mysqli_query($conn, $query_suplier);
?>

<!-- modal Tambah -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Nota Jual Konsinyasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="tambah.php" method="post">
          <div class="form-group">
            <label for="kode_nota">Kode Nota</label>
            <input type="text" name="kode_nota" class="form-control" id="kode_nota" placeholder="Masukan Kode Nota" required>
          </div>
          <div class="form-group">
            <label for="id_suplier">Suplier</label>
            <select name="id_suplier" class="form-control" id="id_suplier" required>
              <option value="">Pilih Suplier</option>
              <?php while($row = mysqli_fetch_assoc($result_suplier)): ?>
                <option value="<?= $row['kode_suplier'] ?>"><?= $row['nama_suplier'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="tgl_penjualan">Tanggal Penjualan</label>
            <input type="date" name="tgl_penjualan" class="form-control" id="tgl_penjualan" required>
          </div>
          <div class="form-group">
            <label for="total_penjualan">Total Penjualan</label>
            <input type="number" name="total_penjualan" class="form-control" id="total_penjualan" value="0" placeholder="0" min="0">
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" id="status" required>
              <option value="">Pilih Status</option>
              <option value="L">Lunas</option>
              <option value="2">Dibayar 25%</option>
              <option value="3">Dibayar 50%</option>
              <option value="4">Dibayar 75%</option>
              <option value="B">Belum Dibayar</option>
            </select>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukan Keterangan">
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal Tambah -->

<!-- modal Edit -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Nota Jual Konsinyasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="edit.php" method="post">
          <div class="form-group">
            <label>Kode Nota</label>
            <input type="text" name="kode_nota" class="form-control" id="edit-kode_nota" readonly required>
          </div>
          <div class="form-group">
            <label>Suplier</label>
            <select name="id_suplier" class="form-control" id="edit-id_suplier" required>
              <option value="">Pilih Suplier</option>
              <?php mysqli_data_seek($result_suplier, 0);
              while($row = mysqli_fetch_assoc($result_suplier)): ?>
                <option value="<?= $row['kode_suplier'] ?>"><?= $row['nama_suplier'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tanggal Penjualan</label>
            <input type="date" name="tgl_penjualan" class="form-control" id="edit-tgl_penjualan" required>
          </div>
          <div class="form-group">
            <label>Total Penjualan</label>
            <input type="number" name="total_penjualan" class="form-control" id="edit-total_penjualan" min="0">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" id="edit-status" required>
              <option value="">Pilih Status</option>
              <option value="L">Lunas</option>
              <option value="2">Dibayar 25%</option>
              <option value="3">Dibayar 50%</option>
              <option value="4">Dibayar 75%</option>
              <option value="B">Belum Dibayar</option>
            </select>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" id="edit-keterangan" placeholder="Masukan Keterangan">
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal Edit -->

<?php include '../script.php'; ?>
</body>

<script type="text/javascript">
  $('#modal-edit').on('show.bs.modal', function(e) {
    var kode_nota        = $(e.relatedTarget).data('kode_nota');
    var id_suplier       = $(e.relatedTarget).data('id_suplier');
    var tgl_penjualan    = $(e.relatedTarget).data('tgl_penjualan');
    var total_penjualan  = $(e.relatedTarget).data('total_penjualan');
    var status           = $(e.relatedTarget).data('status');
    var keterangan       = $(e.relatedTarget).data('keterangan');

    $(e.currentTarget).find('input[name="kode_nota"]').val(kode_nota);
    $(e.currentTarget).find('select[name="id_suplier"]').val(id_suplier);
    $(e.currentTarget).find('input[name="tgl_penjualan"]').val(tgl_penjualan);
    $(e.currentTarget).find('input[name="total_penjualan"]').val(total_penjualan);
    $(e.currentTarget).find('select[name="status"]').val(status);
    $(e.currentTarget).find('input[name="keterangan"]').val(keterangan);
  });
</script>

</html>
<?php
}
?>

