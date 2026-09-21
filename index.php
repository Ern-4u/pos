<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS TMI || Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/AdminLte/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/AdminLte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/AdminLte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/AdminLte/dist/css/adminlte.min.css">

</head>

<?php
require_once 'database/config.php'; 
?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="assets/AdminLte/index2.html"><b>POS</b> Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login untuk masuk ke halaman Dashboard</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="sandi" class="form-control" placeholder="sandi">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="social-auth-links text-center mb-3">
            <button type="submit" id="" name="btn_login" class="btn btn-block btn-primary">
                Login
            </button>
        </div>

      </form>

      
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- modal -->
      <div class="modal fade" id="modal-pin">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Masukan PIN</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="post">
                <div class="form-group">
                  <label for="pin">PIN</label>
                  <input type="number" name="pin2fa" class="form-control" id="pin2fa" placeholder="Enter PIN">
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_pin" class="btn btn-primary">Simpan</button>
              </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



<!-- jQuery -->
<script src="assets/AdminLte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/AdminLte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="assets/AdminLte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/AdminLte/dist/js/adminlte.min.js"></script>

<?php 
  if (isset($_POST['btn_login'])) {
    $username = trim(mysqli_escape_string($conn, $_POST['username']));
    $sandi = sha1(trim(mysqli_escape_string($conn, $_POST['sandi'])));

    $query = "SELECT * FROM users WHERE username='$username' AND sandi='$sandi'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      $data_user = mysqli_fetch_assoc($result);
      $_SESSION['temp_login'] = true;
      $_SESSION['username']   = $data_user['username'];
      $_SESSION['peran']      = $data_user['peran'];
      $_SESSION['nama_panggilan']       = $data_user['nama_panggilan'];
      $_SESSION['sandi']      = $data_user['sandi'];
      $_SESSION['pin2fa']      = $data_user['pin2fa'];


      //redirect ke modal untuk memasukkan PIN
      echo "
      <script>
          $(function() {
              $('#modal-pin').modal('show');
          }); 
      </script>" ;
      
    } else {
      // Jika Login Gagal
      echo "
      <script>
          $(function() {
              var Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: true,
                  timer: 300000
              });

              // Langsung tampilkan alert error
              Toast.fire({
                  icon: 'error',
                  title: 'Username atau sandi salah!'
              });
          });
      </script>";
      
    }
}


if (isset($_POST['btn_pin'])) {
  $pin2fa = trim(mysqli_escape_string($conn, $_POST['pin2fa']));
  $username = $_SESSION['username'];
  $peran =$_SESSION['peran'];
  $query = "SELECT * FROM users WHERE username='$username' AND pin2fa ='$pin2fa'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
      $data_user = mysqli_fetch_assoc($result);

      if ($peran == 'S') {
        
        $_SESSION['username'] = $data_user['username'];
        $_SESSION['pin2fa'] = $data_user['pin2fa'];
        $_SESSION['peran'] = $data_user['peran'];
        $_SESSION['nama_panggilan'] = $data_user['nama_panggilan'];
        $_SESSION['sandi'] = $data_user['sandi'];
            header("Location: home_superadmin");
        exit();
      } elseif ($peran == 'K') {
        $_SESSION['username'] = $data_user['username'];
        $_SESSION['pin2fa'] = $data_user['pin2fa'];
        $_SESSION['peran'] = $data_user['peran'];
        $_SESSION['nama_panggilan'] = $data_user['nama_panggilan'];
        $_SESSION['sandi'] = $data_user['sandi'];
        header("Location: kasir_home");
        exit();
      } else {
        echo "
        <script>
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    timer: 30000
                });

                // Langsung tampilkan alert error
                Toast.fire({
                    icon: 'error',
                    title: 'peran tidak valid!'
                });
            });
        </script>";
      }

  } else {
      // Jika PIN salah
      echo "
      <script>
          $(function() {
              var Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: true,
                  timer: 30000
              });

              // Langsung tampilkan alert error
              Toast.fire({
                  icon: 'error',
                  title: 'PIN salah!'
              });
          });
      </script>";
  }
}

  
?>


</body>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: true,
      timer: 15000
    });

    $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        icon: 'success',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultInfo').click(function() {
      Toast.fire({
        icon: 'info',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultError').click(function() {
      Toast.fire({
        icon: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultWarning').click(function() {
      Toast.fire({
        icon: 'warning',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultQuestion').click(function() {
      Toast.fire({
        icon: 'question',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultTopLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'topLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomRight').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomRight',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultAutohide').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        autohide: true,
        delay: 750,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultNotFixed').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        fixed: false,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultFull').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });
    $('.toastsDefaultFullImage').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        image: '../../dist/img/user3-128x128.jpg',
        imageAlt: 'User Picture',
      })
    });
    $('.toastsDefaultSuccess').click(function() {
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultInfo').click(function() {
      $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultWarning').click(function() {
      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultMaroon').click(function() {
      $(document).Toasts('create', {
        class: 'bg-maroon',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });
</script>

</html>
