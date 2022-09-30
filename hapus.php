<?php
// periksa apakah user sudah login, cek kehadiran session name
// jika tidak ada, redirect ke login.php
session_start();
if (!isset($_SESSION["nama"])) {
  header("Location: login.php");
}

// buka koneksi dengan MySQL
include("conection.php");

// cek apakah form telah di submit (untuk menghapus data)
if (isset($_POST["submit"])) {
  // form telah disubmit, proses data

  // ambil nilai id_mhs
  $id_mhs = htmlentities(strip_tags(trim($_POST["id_mhs"])));
  $nama = htmlentities(strip_tags(trim($_POST["nama"])));
  // filter data
  $id_mhs = mysqli_real_escape_string($link, $id_mhs);
  $nama = mysqli_real_escape_string($link, $nama);

  //jalankan query DELETE
  $query = "DELETE FROM tbl_mahasiswa WHERE id_mhs=$id_mhs";
  $hasil_query = mysqli_query($link, $query);

  //periksa query, tampilkan pesan kesalahan jika gagal
  if ($hasil_query) {
    // DELETE berhasil, redirect ke tampil_mahasiswa.php + pesan
    $pesan = "Mahasiswa dengan  nama = \"<b>{$nama}</b>\" sudah berhasil di hapus";
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
