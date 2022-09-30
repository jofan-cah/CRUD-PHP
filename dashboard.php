<?php
// periksa apakah user sudah login, cek kehadiran session name 
// jika tidak ada, redirect ke login.php
session_start();
if (!isset($_SESSION["nama"])) {
  header("Location: login.php");
}

// buka koneksi dengan MySQL
include("conection.php");

// ambil pesan jika ada  
if (isset($_GET["pesan"])) {
  $pesan = $_GET["pesan"];
}

// siapkan query untuk menampilkan seluruh data dari tabel mahasiswa
$query = "SELECT * FROM mahasiswa ORDER BY nama ASC";
?>

<!DOCTYPE html>
<html lang="id">


<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>DASHBOARD UI</title>

  <!-- STYLE -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <link rel="stylesheet" href="./assets/css/styleD.css" />

  <!-- FONT AWESOME -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <!-- ICON -->
  <link rel="shortcut icon" href="https://hmpti-udb.my.id/assets/img/logo.png?1624943673" />
</head>

<body>
  <!-- BOX KIRI -->
  <div class="sidebar shadow">
    <header>
      <img src="./assets/img/logo.png" alt="" class="gmb" />
      <div class="atasBawah">
        <h1>hmpti training</h1>
        <h2>CRUD with PHP-Native</h2>
      </div>
    </header>

    <ul>
      <li>
        <img src="./assets/img/iconDb.png" class="iconNav" /><a href="dashboard.php">Dashboard</a>
      </li>
      <li>
        <img src="./assets/img/iconCrud.png" class="iconNav" /><a href="tampil.php">Start CRUD</a>
      </li>
      <li>
        <a href="logout.php">Keluar</a>
      </li>
    </ul>
  </div>

  <!-- BOX KANAN -->
  <div class="w-77 h-100">
    <div class="boxHead p-5">
      <h3 class="text-uppercase teksUtama">welcome to hmpti training</h3>
      <h3 class="teksDesc">hello, ..., happy coding :)</h3>
    </div>
    <div class="foto">
           <img src="./assets/img/utama.png" alt="" class="img-fluid" />
    </div>

    <!-- FOOTER -->
    <div class="footer">
      <h4 class="teksFooter">@HMPTI-UDB</h4>
    </div>
  </div>
</body>

</html>
