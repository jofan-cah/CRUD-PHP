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
  // form telah disubmit, proses data

  // ambil semua nilai form

  $nim          = htmlentities(strip_tags(trim($_POST["nim"])));
  $nama         = htmlentities(strip_tags(trim($_POST["nama"])));
  $kelas = htmlentities(strip_tags(trim($_POST["kelas"])));
  $kota          = htmlentities(strip_tags(trim($_POST["kota"])));
  $prodi      = htmlentities(strip_tags(trim($_POST["prodi"])));
  $fakultas     = htmlentities(strip_tags(trim($_POST["fakultas"])));

  // siapkan variabel untuk menampung pesan error
  $pesan_error = "";



  // cek ke database, apakah sudah ada nomor NIM yang sama
  // filter data $nim
  $nim = mysqli_real_escape_string($link, $nim);
  $query = "SELECT * FROM tbl_mahasiswa WHERE nim='$nim'";
  $hasil_query = mysqli_query($link, $query);

  // cek jumlah record (baris), jika ada, $nim tidak bisa diproses
  $jumlah_data = mysqli_num_rows($hasil_query);
  if ($jumlah_data >= 1) {
    $pesan_error .= "NIM yang sama sudah digunakan <br>";
  }


  // jika tidak ada error, input ke database
  if ($pesan_error === "") {

    // filter semua data
    $nim          = mysqli_real_escape_string($link, $nim);
    $nama         = mysqli_real_escape_string($link, $nama);
    $kelas = mysqli_real_escape_string($link, $kelas);
    $fakultas     = mysqli_real_escape_string($link, $fakultas);
    $prodi      = mysqli_real_escape_string($link, $prodi);
    $kota          = mysqli_real_escape_string($link, $kota);



    //buat dan jalankan query INSERT
    $query = "INSERT INTO tbl_mahasiswa (nim,nama,kelas,kota,prodi,fakultas) VALUES ";
    $query .= "($nim, '$nama', '$kelas', ";
    $query .= "'$kota',$prodi,$fakultas)";

    $result = mysqli_query($link, $query);

    //periksa hasil query
    if ($result) {
      // INSERT berhasil, redirect ke tampil_mahasiswa.php + pesan
      $pesan = "Mahasiswa dengan nama = \"<b>$nama</b>\" sudah berhasil di tambah";
      $pesan = urlencode($pesan);
      header("Location: tampil.php?pesan={$pesan}");
    } else {
      die("Query gagal dijalankan: " . mysqli_errno($link) .
        " - " . mysqli_error($link));
    }
  } else {
    header("Location: tampil.php?pesan={$pesan_error}");
  }
} else {

  // form diakses secara langsung!
  // redirect ke edit_mahasiswa.php
  header("Location: tampil.php");
}
