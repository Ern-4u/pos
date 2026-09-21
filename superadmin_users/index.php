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
  $hal = "superadmin_users";

  $query = "SELECT * FROM users";
  $result = mysqli_query($conn, $query);
  $data_admin = mysqli_fetch_all($result, MYSQLI_ASSOC);
 

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
                <h3 class="card-title">Data User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah-user">
                  <i class="fas fa-plus"></i>
                  Tambah Admin
                </button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Username</th>
                    <th>Nama Pengguna</th>
                    <th>Role</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                  $no = 1; 
                  foreach ($data_admin as $admin) : ?>
                    <tr>
                      <td><?=  $no++ ; ?></td>
                      <td><?= $admin['username']; ?></td>
                      <td><?= $admin['nama_panggilan']; ?></td>
                      <td>
                        <?php 
                        $peran = $admin['peran'];
                        if ($peran == 'S') {
                          echo 'Super Admin';
                        } else {
                          echo 'Kasir';
                        }
                        ?>
                      </td>
                      <td>
                        <a href="hapus.php?user=<?= $admin['username']; ?>" 
                        class="btn btn-danger btn-xs" onclick="return confirm('YAKIN LU?')"
                        ><i class="fas fa-trash"></i></a>
                        <button class="btn btn-warning btn-xs" type="submit" data-target="#modal-edit-user" data-username="<?= $admin['username'] ?>" 
                        data-nama_panggilan="<?= $admin['nama_panggilan']?>" data-peran="<?= $admin['peran']?>" data-toggle="modal">
                        <i class="fas fa-edit"> </i>
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


<!-- modal Tambah -->
      <div class="modal fade" id="modal-tambah-user">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambah.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" maxlength="15" id="username" placeholder="Masukan username" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" class="form-control" id="nama_panggilan" placeholder="Masukan Nama" required>
                </div>
                <div class="form-group">
                  <label for="peran">Role</label>
                  <select name="peran" class="form-control" id="peran">
                    <option value="">--Pilih Peran--</option>
                    <option value="S">Super Admin</option>
                    <option value="K">Kasir</option>
                  </select>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_tambah_admin" class="btn btn-primary">Simpan</button>
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
      <div class="modal fade" id="modal-edit-user" >
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
                    <input type="hidden" name="id" id="edit-id">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="edit-username" name="username" class="form-control"  placeholder="Masukan username" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Panggilan</label>
                    <input type="text" id="edit-nama_panggilan" name="nama_panggilan" class="form-control"  placeholder="Masukan username">
                </div>
                <div class="form-group">
                  <label for="peran">Peran</label>
                  <select name="peran" id="edit-peran" class="form-control" >
                    <option value="">--Masukan Peran--</option>
                    <option value="S">Super Admin</option>
                    <option value="K">Kasir</option>
                  </select>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_edit_admin" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
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
   $('#modal-edit-user').on('show.bs.modal', function(e) {

   var id = $(e.relatedTarget).data('id');
   var username = $(e.relatedTarget).data('username');
   var nama_panggilan = $(e.relatedTarget).data('nama_panggilan');
   var peran = $(e.relatedTarget).data('peran');

  

  $(e.currentTarget).find('input[name="id"]').val(id);
  $(e.currentTarget).find('input[name="username"]').val(username);
  $(e.currentTarget).find('input[name="nama_panggilan"]').val(nama_panggilan);
  $(e.currentTarget).find('select[name="peran"]').val(peran);
   
   });
 
</script> 


</html>
<?php
}
?>