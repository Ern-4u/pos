<?php 

require_once '../database/config.php';

if (isset($_POST['btn_edit_admin'])) {

  $id = trim(mysqli_real_escape_string($conn, $_POST['id']));
  $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
  $password = SHA1(trim(mysqli_real_escape_string($conn, $_POST['password'])));
  $pin = trim(mysqli_real_escape_string($conn, $_POST['pin']));
  $role = trim(mysqli_real_escape_string($conn, $_POST['role']));


  $ambil_data_admin_lama = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
  $data_admin_lama =mysqli_fetch_array($ambil_data_admin_lama);
  $password = empty($_POST['password']) ? $data_admin_lama['password'] : $password;

  $query = "UPDATE users SET username='$username', password='$password', pin='$pin', role='$role' WHERE id='$id'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo "<script>alert('Data admin berhasil diperbarui.'); window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat memperbarui data admin.');</script>";
  }
}

?>