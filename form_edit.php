 <?php
  // periksa apakah user sudah login, cek kehadiran session name
  // jika tidak ada, redirect ke login.php
  session_start();
  if (!isset($_SESSION["nama"])) {
    header("Location: login.php");
  }

  // buka koneksi dengan MySQL
  include("conection.php");

  // cek apakah form telah di submit
  if (isset($_POST["submit"])) {
    // form telah disubmit, cek apakah berasal dari edit_mahasiswa.php
    // atau update data dari form_edit.php

    $id_mhs          = htmlentities(strip_tags(trim($_POST["id_mhs"])));
    $nim          = htmlentities(strip_tags(trim($_POST["nim"])));
    $nama         = htmlentities(strip_tags(trim($_POST["nama"])));
    $kelas = htmlentities(strip_tags(trim($_POST["kelas"])));
    $kota          = htmlentities(strip_tags(trim($_POST["kota"])));
    $prodi      = htmlentities(strip_tags(trim($_POST["prodi"])));
    $fakultas     = htmlentities(strip_tags(trim($_POST["fakultas"])));


    // buka koneksi dengan MySQL
    include("conection.php");

    // filter semua data
    $nim          = mysqli_real_escape_string($link, $nim);
    $nama         = mysqli_real_escape_string($link, $nama);
    $kelas = mysqli_real_escape_string($link, $kelas);
    $fakultas     = mysqli_real_escape_string($link, $fakultas);
    $prodi      = mysqli_real_escape_string($link, $prodi);
    $kota          = mysqli_real_escape_string($link, $kota);




    //buat dan jalankan query UPDATE
    $query  = "UPDATE tbl_mahasiswa SET ";
    $query .= "nama = '$nama', kelas = '$kelas', ";
    $query .= "kota = '$kota', fakultas='$fakultas', nim='$nim',";
    $query .= "prodi = '$prodi' ";
    $query .= "WHERE id_mhs = '$id_mhs'";

    $result = mysqli_query($link, $query);

    //periksa hasil query
    if ($result) {
      // INSERT berhasil, redirect ke tampil_mahasiswa.php + pesan
      $pesan = "Mahasiswa dengan nama = \"<b>$nama</b>\" sudah berhasil di update";
      $pesan = urlencode($pesan);
      header("Location: tampil.php?pesan={$pesan}");
    } else {
      die("Query gagal dijalankan: " . mysqli_errno($link) .
        " - " . mysqli_error($link));
    }
  } else {
    // form diakses secara langsung!
    // redirect ke edit_mahasiswa.php
    header("Location: tampil.php");
  }


  ?>