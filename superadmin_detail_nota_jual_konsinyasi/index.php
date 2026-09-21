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
  $kode_nota = @$_GET['kode_nota'];

  // Ambil info header nota
  $q_header = mysqli_query($conn, "SELECT njk.*, s.nama_suplier 
                FROM nota_jual_konsinyasi njk
                LEFT JOIN suplier s ON njk.id_suplier = s.kode_suplier
                WHERE njk.kode_nota = '$kode_nota'") or die(mysqli_error($conn));
  $header = mysqli_fetch_assoc($q_header);

  // Ambil detail nota
  $query = "SELECT dnjk.*, bk.nama_barang
            FROM detail_nota_jual_konsinyasi dnjk
            LEFT JOIN barang_konsinyasi bk ON dnjk.kode_barang_konsinyasi = bk.kode_barang_konsinyasi
            WHERE dnjk.kode_nota = '$kode_nota'";
  $result = mysqli_query($conn, $query);
  $data_detail = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

        <!-- Info Header Nota -->
        <?php if ($header): ?>
        <div class="card card-info mb-3">
          <div class="card-header">
            <h3 class="card-title">Info Nota Jual Konsinyasi</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><td width="150"><b>Kode Nota</b></td><td>: <?= $header['kode_nota'] ?></td></tr>
                  <tr><td><b>Suplier</b></td><td>: <?= $header['nama_suplier'] ?></td></tr>
                  <tr><td><b>Tanggal</b></td><td>: <?= $header['tgl_penjualan'] ?></td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><td width="150"><b>Total Penjualan</b></td><td>: <b>Rp <?= number_format($header['total_penjualan'], 0, ',', '.') ?></b></td></tr>
                  <tr><td><b>Status</b></td><td>:
                    <?php
                      if ($header['status'] == 'L') echo '<span class="badge badge-success">Lunas</span>';
                      elseif ($header['status'] == '2') echo '<span class="badge badge-warning">Dibayar 25%</span>';
                      elseif ($header['status'] == '3') echo '<span class="badge badge-warning">Dibayar 50%</span>';
                      elseif ($header['status'] == '4') echo '<span class="badge badge-warning">Dibayar 75%</span>';
                      else echo '<span class="badge badge-danger">Belum Dibayar</span>';
                    ?>
                  </td></tr>
                  <tr><td><b>Keterangan</b></td><td>: <?= $header['keterangan'] ?></td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Tabel Detail -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detail Nota Jual Konsinyasi — <?= $kode_nota ?></h3>
          </div>
          <div class="card-body">
            <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-primary mb-3" type="button">
              <i class="fas fa-plus"></i> Tambah Item
            </button>
            <a href="nota.php?id=<?= $kode_nota ?>" target="_blank" class="btn btn-info mb-3">
              <i class="fas fa-file-pdf"></i> Cetak Nota
            </a>
            <a href="../superadmin_nota_jual_konsinyasi/" class="btn btn-secondary mb-3">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>ID</th>
                  <th>Kode Nota</th>
                  <th>Barang Konsinyasi</th>
                  <th>Jumlah</th>
                  <th>Harga Jual</th>
                  <th>Total Harga</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($data_detail as $s) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['kode_nota'] ?></td>
                    <td><?= $s['nama_barang'] ?></td>
                    <td><?= $s['jumlah'] ?></td>
                    <td>Rp <?= number_format($s['harga_jual'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($s['total_harga_jual'], 0, ',', '.') ?></td>
                    <td>
                      <a href="hapus.php?id=<?= $s['id'] ?>&kode_nota=<?= $s['kode_nota'] ?>" 
                         class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus item ini?')">
                        <i class="fas fa-trash"></i>
                      </a>
                      <button class="btn btn-warning btn-xs"
                        data-toggle="modal" data-target="#modal-edit"
                        data-id="<?= $s['id'] ?>"
                        data-kode_nota="<?= $s['kode_nota'] ?>"
                        data-kode_barang_konsinyasi="<?= $s['kode_barang_konsinyasi'] ?>"
                        data-jumlah="<?= $s['jumlah'] ?>"
                        data-harga_jual="<?= $s['harga_jual'] ?>"
                        data-total_harga_jual="<?= $s['total_harga_jual'] ?>">
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
$query_barang_konsinyasi = mysqli_query($conn, "SELECT * FROM barang_konsinyasi WHERE stok > 0") or die(mysqli_error($conn));
?>

<!-- modal Tambah Item -->
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Item Nota Jual Konsinyasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="tambah.php" method="post">
          <div class="form-group">
            <label>Kode Nota</label>
            <input name="kode_nota" value="<?= $kode_nota ?>" class="form-control" readonly required>
          </div>
          <div class="form-group">
            <label for="kode_barang_konsinyasi">Barang Konsinyasi</label>
            <select name="kode_barang_konsinyasi" class="form-control" id="kode_barang_konsinyasi" required>
              <option value="">Pilih Barang</option>
              <?php while($row = mysqli_fetch_assoc($query_barang_konsinyasi)): ?>
                <option value="<?= $row['kode_barang_konsinyasi'] ?>" 
                        data-harga="<?= $row['harga_jual'] ?>">
                  <?= $row['nama_barang'] ?> (Stok: <?= $row['stok'] ?>)
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah-tambah" min="1" placeholder="Masukan Jumlah" required>
          </div>
          <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" id="harga_jual-tambah" min="0" placeholder="Masukan Harga Jual" required>
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

<!-- modal Edit Item -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Item Nota Jual Konsinyasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="edit.php" method="post">
          <input type="hidden" name="id" id="edit-id">
          <input type="hidden" name="kode_nota" id="edit-kode_nota">
          <div class="form-group">
            <label>Kode Barang Konsinyasi</label>
            <input type="text" name="kode_barang_konsinyasi" class="form-control" id="edit-kode_barang" readonly>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="edit-jumlah" min="1" required>
          </div>
          <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" id="edit-harga_jual" min="0" required>
          </div>
          <div class="form-group">
            <label>Total Harga Jual</label>
            <input type="number" name="total_harga_jual" class="form-control" id="edit-total_harga_jual" min="0" required>
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

<?php include '../script.php'; ?>
</body>

<script>
  // Auto-isi harga jual saat barang dipilih
  $('#kode_barang_konsinyasi').on('change', function() {
    var harga = $(this).find(':selected').data('harga');
    $('#harga_jual-tambah').val(harga || '');
  });

  // Modal Edit
  $('#modal-edit').on('show.bs.modal', function(e) {
    var id                    = $(e.relatedTarget).data('id');
    var kode_nota             = $(e.relatedTarget).data('kode_nota');
    var kode_barang           = $(e.relatedTarget).data('kode_barang_konsinyasi');
    var jumlah                = $(e.relatedTarget).data('jumlah');
    var harga_jual            = $(e.relatedTarget).data('harga_jual');
    var total_harga_jual      = $(e.relatedTarget).data('total_harga_jual');

    $('#edit-id').val(id);
    $('#edit-kode_nota').val(kode_nota);
    $('#edit-kode_barang').val(kode_barang);
    $('#edit-jumlah').val(jumlah);
    $('#edit-harga_jual').val(harga_jual);
    $('#edit-total_harga_jual').val(total_harga_jual);
  });
</script>

</html>
<?php
}
?>

