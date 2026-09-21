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
  $hal = "superadmin_suplier";

  $query = "SELECT * FROM suplier";
  $result = mysqli_query($conn, $query);
  $data_suplier = mysqli_fetch_all($result, MYSQLI_ASSOC);
 

  

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
                <h3 class="card-title">Data Suplier</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="tambah.php" class="btn btn-primary mb-3" type="button"><i class="fas fa-plus"></i> Tambah Data</a>
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode suplier?</th>
                    <th>Nama</th>
                    <th>Nama PIC</th>
                    <th>Kontak PIC</th>
                    <th>Alamat</th>
                    <th>Sosmed</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                  $no = 1; 
                  foreach ($data_suplier as $s) : ?>
                    <tr>
                      <td><?=  $no++ ; ?></td>
                      <td><?= $s['kode_suplier']; ?></td>
                      <td><?= $s['nama_suplier']; ?></td>
                      <td><?= $s['nama_pic'] ?> </td>
                      <td><?= $s['kontak_pic'] ?> </td>
                      <td><?= $s['alamat'] ?> </td>
                      <td>
                        <a href="<?= $s['website'] ?>" target="_blank" class="btn btn-default btn-s"><i class="bi bi-browser-chrome"></i></a>
                        <a href="https://instagram.com/<?= $s['akun_ig'] ?>" target="_blank" class="btn btn-default btn-s"><i class="bi bi-instagram"></i></a>
                        <a href="https://tiktok.com/<?= $s['akun_tiktok'] ?>" target="_blank" class="btn btn-default btn-s"><i class="bi bi-tiktok"></i></a>
                      </td>
                      <td>
                        <a href="hapus.php?kode_suplier=<?= $s['kode_suplier']; ?>" 
                        class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')">
                        <i class="fas fa-trash"></i></a>
                        <a href="edit.php?kode_suplier=<?= $s['kode_suplier'] ?>" class="btn btn-warning btn-xs">
                          <i class="fas fa-edit"></i></a>
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


<!-- modal Tambah -->
      <div class="modal fade" id="modal-tambah-mahasiswa">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Mahasiswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambah.php" method="post">
                <div class="form-group">
                    <label for="nim">Nim</label>
                    <input type="number" name="nim" class="form-control" id="nim" placeholder="Masukan NIM" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Ands" required>
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" id="kontak" placeholder="Masukan Kontak" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
                </div>
                <div class="form-group">
                  <label for="kelamin">Jenis Kelamin</label>
                  <select name="kelamin" class="form-control" id="kelamin">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_tambah_mahasiswa" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Tambah -->

<?php
 
?>


      <!-- modal Edit -->
      <div class="modal fade" id="modal-edit" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit.php" method="post" id="editForm">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="number" id="edit-nim" name="nim" class="form-control"  placeholder="Masukan NIM" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="edit-nama" name="nama" class="form-control"  placeholder="Masukan username">
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" id="edit-kontak" name="kontak" class="form-control"  placeholder="Masukan kontak" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="edit-email" name="email" class="form-control"  placeholder="Masukan Email" >
                </div>
                <div class="form-group">
                  <label for="kelamin">Kelamin</label>
                  <select name="kelamin" id="edit-kelamin" class="form-control" >
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_edit_mahasiswa" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Edit -->

      <!-- modal Import -->
      <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Import Data Matkul</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="import.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <a href="template/temp_mahasiswa.xls" class="btn btn-warning "> Download Template</a>
                </div>
                <div class="form-group">
                    <label for="file_excel">Upload File Template</label>
                    <input type="file" accept=".xls" name="file_excel" class="form-control" id="file_excel" placeholder="Upload File Excel" required>
                </div>
                
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_import" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal Import -->


<!-- jQuery -->
<?php include '../script.php'; ?>
</body>

<script type="text/javascript">
   $('#modal-edit').on('show.bs.modal', function(e) {

   var nim = $(e.relatedTarget).data('nim');
   var nama = $(e.relatedTarget).data('nama');
   var kontak = $(e.relatedTarget).data('kontak');
   var email = $(e.relatedTarget).data('email');
   var kelamin = $(e.relatedTarget).data('kelamin');

 

  $(e.currentTarget).find('input[name="nim"]').val(nim);
  $(e.currentTarget).find('input[name="nama"]').val(nama);
  $(e.currentTarget).find('input[name="kontak"]').val(kontak);
  $(e.currentTarget).find('input[name="email"]').val(email);
  $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
   
   });
 
</script> 


</html>
<?php
}
?>