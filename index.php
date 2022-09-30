<?php
// langsung redirect ke halaman tampil mahasiswa
// header("Location: dashboard.php");
session_start();

$id_mhs = '';

var_dump(!empty($id_mhs));






?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HPTI</title>
  <!-- <link rel="stylesheet" href="./assets/css/style.css"> -->
</head>

<body>
  <form action="" method="POST">

    <input type="hidden" name="id_mhs" value="1">
    <input type="submit" name="submit" value="klik">
  </form>


  <h1>


  </h1>

  <img src="./assets/img/logo.png" alt="">

</body>



</html>