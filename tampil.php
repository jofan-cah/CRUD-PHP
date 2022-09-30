<?php
// periksa apakah user sudah login, cek kehadiran session name 
// jika tidak ada, redirect ke login.php
session_start();
if (!isset($_SESSION["nama"])) {
  header("Location: login.php");
}

$pesan_error = '';

// buka koneksi dengan MySQL
include("conection.php");

// ambil pesan jika ada  
if (isset($_GET["pesan"])) {
  $pesan = $_GET["pesan"];
}
// siapkan query untuk menampilkan seluruh data dari tabel mahasiswa
$query = "SELECT * FROM tbl_mahasiswa ORDER BY nama ASC";
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />

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
    <div class="p-2">
      <div class="row">
        <div class="col"> <?php
                          // tampilkan pesan jika ada
                          if (isset($pesan)) : ?>
            <div class='pesan'><?= $pesan ?></div>
            <?php
                            // tampilkan error jika ada
                            if ($pesan_error !== "") {
                              echo "<div class=\"pesanError\">$pesan_error</div>";
                            }
            ?>
          <?php endif ?>
        </div>
        <div class="col ">
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
              Tambah
            </button>
            <!-- <button class="btn btn-primary" type="button">Button</button> -->
          </div>


        </div>
      </div>



    </div>


    <div class="gabut pt-5">
      <table id="example">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Nim</th>
            <th>Kelas</th>
            <th>Kota</th>
            <th>Prodi</th>
            <th>Fakultas</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php

          // jalankan query
          $result = mysqli_query($link, $query);

          if (!$result) {
            die("Query Error: " . mysqli_errno($link) .
              " - " . mysqli_error($link));
          }
          foreach ($result as $key => $value) { ?>
            <tr>
              <th><?= $value['nama'] ?></th>
              <th><?= $value['nim'] ?></th>
              <th><?= $value['kelas'] ?></th>
              <th><?= $value['kota'] ?></th>
              <th>
                <?php if ($value['prodi'] == 0) {
                  echo 'Teknik Informatika';
                } elseif ($value['prodi'] == 1) {
                  echo 'Sistem Informasi';
                } else {
                  echo 'Manajemen Komputer';
                } ?>
              </th>
              <th><?php if ($value['fakultas'] == 0) {
                    echo 'FIKES';
                  } else {
                    echo 'FIKOM';
                  } ?></th>
              <th>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?= $value['id_mhs'] ?>">
                  Edit
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $value['id_mhs'] ?>">
                  Hapus
                </button>
              </th>
            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
          <tr>
            <th>Nama</th>
            <th>Nim</th>
            <th>Kelas</th>
            <th>Kota</th>
            <th>Prodi</th>
            <th>Fakultas</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
    </div>

  </div>


  <!-- Tambah -->
  <div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Form Tambah</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="form_tambah.php" method="post">

            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" id="nama">

            </div>
            <div class="mb-3">
              <label for="nim" class="form-label">Nim</label>
              <input type="text" name="nim" class="form-control" id="nim">
            </div>

            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas</label>
              <input type="text" name="kelas" class="form-control" id="kelas">
            </div>

            <div class="mb-3">
              <label for="kota" class="form-label">Kota</label>
              <input type="text" name="kota" class="form-control" id="kota">
            </div>

            <div class="mb-3">
              <label for="prodi" class="form-label">Prodi</label>
              <select class="form-select" name="prodi" aria-label="Default select example">
                <option value="0">Teknik Informatika</option>
                <option value="1">Sistem Informasi</option>
                <option value="2">Manajemen Komputer</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="fakultas" class="form-label">Fakultas</label>
              <select class="form-select" name="fakultas" aria-label="Default select example">
                <option value="0">FIKES</option>
                <option value="1">FIKOM</option>
              </select>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Kirim</button> -->
          <input type="submit" class="btn btn-primary" name="submit" value="Tambah">
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Modal EDIT -->
  <?php
  // jalankan query
  $result = mysqli_query($link, $query);

  if (!$result) {
    die("Query Error: " . mysqli_errno($link) .
      " - " . mysqli_error($link));
  }


  foreach ($result as $key => $value) : ?>

    <div class="modal fade" id="edit<?= $value['id_mhs'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="form_edit.php" method="post">
              <input type="hidden" name="id_mhs" value="<?= $value['id_mhs'] ?>">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" aria-describedby="emailHelp" value="<?= $value['nama'] ?>">

              </div>
              <div class="mb-3">
                <label for="nim" class="form-label">Nim</label>
                <input type="text" name="nim" value="<?= $value['nim'] ?>" class="form-control" id="nim">
              </div>

              <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" value="<?= $value['kelas'] ?>" id="kelas">
              </div>

              <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" value="<?= $value['kota'] ?>" name="kota" class="form-control" id="kota">
              </div>

              <div class="mb-3">
                <label for="prodi" class="form-label">Prodi</label>
                <select class="form-select" name="prodi" aria-label="Default select example">
                  <option value="0" <?= $value['prodi'] == 0 ? 'selected' : '' ?>>Teknik Informatika</option>
                  <option value="1" <?= ($value['prodi'] == 1 ? 'selected' : '') ?>>Sistem Informasi</option>
                  <option value="2" <?= $value['prodi'] == 2 ? 'selected' : '' ?>>Manajemen Komputer</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas</label>
                <select class="form-select" name="fakultas" aria-label="Default select example">
                  <option value="0" <?= $value['fakultas'] == 0 ? 'selected' : '' ?>>FIKES</option>
                  <option value="1" <?= $value['fakultas'] == 1 ? 'selected' : '' ?>>FIKOM</option>
                </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Kirim</button> -->
            <input type="submit" class="btn btn-primary" name="submit" value="Edit">
          </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach ?>


  <?php
  $result = mysqli_query($link, $query);

  if (!$result) {
    die("Query Error: " . mysqli_errno($link) .
      " - " . mysqli_error($link));
  }

  foreach ($result as $key => $value) : ?>

    <div class="modal fade" id="hapus<?= $value['id_mhs'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h3>Apakah Anda yakin ingin menghapus

            </h3>
            <h3 class="btn btn-primary disabled"> <?= $value['nama'] ?></h3>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="hapus.php" method="post">
              <input type="hidden" name="id_mhs" value="<?= $value['id_mhs'] ?>" i>
              <input type="hidden" name="nama" value="<?= $value['nama'] ?>" id="">
              <input type="submit" class="btn btn-primary" name="submit" value="Hapus">
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>

  ?>




</body>

<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>

</html>
