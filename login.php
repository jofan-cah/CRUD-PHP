<?php

// ambil pesan jika ada
if (isset($_GET["pesan"])) {
  $pesan = $_GET["pesan"];
}

// cek apakah form telah di submit
if (isset($_POST["submit"])) {
  // form telah disubmit, proses data

  // ambil nilai form
  $email = htmlentities(strip_tags(trim($_POST["email"])));
  $password = htmlentities(strip_tags(trim($_POST["password"])));

  // siapkan variabel untuk menampung pesan error
  $pesan_error = "";

  // cek apakah "email" sudah diisi atau tidak
  if (empty($email)) {
    $pesan_error .= "email belum diisi <br>";
  }

  // cek apakah "password" sudah diisi atau tidak
  if (empty($password)) {
    $pesan_error .= "Password belum diisi <br>";
  }

  // buat koneksi ke mysql dari file connection.php
  include("conection.php");

  // filter dengan mysqli_real_escape_string
  $email = mysqli_real_escape_string($link, $email);
  $password = mysqli_real_escape_string($link, $password);

  // generate hashing
  $password_sha1 = sha1($password);


  // cek apakah email dan password ada di tabel admin
  $query = "SELECT * FROM tbl_admin WHERE email = '$email'";
  $result = mysqli_query($link, $query);

  // cek apakah  password ada di tabel admin
  $passwordQuery = "SELECT * FROM tbl_admin WHERE password = '$password_sha1'";
  $Presult = mysqli_query($link, $passwordQuery);



  if (mysqli_num_rows($result) == 0) {
    // data tidak ditemukan, buat pesan error
    $pesan_error .= "email tidak sesuai";
  } elseif (mysqli_num_rows($Presult) == 0) {
    // cek apakah email dan password ada di tabel admin
    $pesan_error .= "Password tidak sesuai";
  }

  // bebaskan memory
  mysqli_free_result($result);

  // tutup koneksi dengan database MySQL
  mysqli_close($link);

  // jika lolos validasi, set session
  if ($pesan_error === "") {
    // memulai sesion
    session_start();
    // buat session nama
    $_SESSION["nama"] = $email;
    header("Location: dashboard.php");
  }
} else {
  // form belum disubmit atau halaman ini tampil untuk pertama kali
  // berikan nilai awal untuk semua isian form
  $pesan_error = "";
  $email = "";
  $password = "";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Login</title>
  <!-- ICON -->
  <link rel="shortcut icon" href="https://hmpti-udb.my.id/assets/img/logo.png?1624943673" />

  <!-- STYLE -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
  <section class="login d-flex">

    <div class="login-left w-50 h-100 ">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-8">
          <h2 class="header1">login panel</h2>
          <h2 class="header2">Login to Learn More Skill</h2>
          <!-- BOX LEFT -->
          <?php
          // tampilkan pesan jika ada
          if (isset($pesan)) {
            echo "<div class=\"pesan\">$pesan</div>";
          }

          // tampilkan error jika ada
          if ($pesan_error !== "") {
            echo "<div class=\"error\">$pesan_error</div>";
          }
          ?>

          <!-- FORM -->
          <form action="login.php" class="formLogin" method="post">
            <!-- EMAIl -->
            <div class="inputEmail">
              <input type="email" name="email" value="<?= $email ?>" autocomplete="off" required />
              <label for="email" class="labelName">
                <span class="contentName">Email</span>
              </label>
            </div>

            <!-- PASSWORD -->
            <div class="inputPw">
              <input type="password" name="password" value="<?= $password ?>" autocomplete="off" required />
              <label for="password" class="labelName">
                <span class="contentName">Password</span>
              </label>
            </div>

            <div style="margin-top: 10px">
              <input type="submit" name="submit" class="btnLogin" value="submit" />
            </div>
          </form>

          <!-- FOOTER -->
          <div class="text-center">
            <span class="teksFooter">Don't have an account?</span>
            <!-- <a href="#" class="teksFooter2">Sign Up</a> -->
            <input type="submit" name="submit" class="teksFooter2" value="Log In">
          </div>

        </div>
      </div>
    </div>

    <!-- BOX RIGHT -->
    <div class="login-right w-50 h-100 ">
      <picture>
        <img src="../Sibarmati6/assets/img/img1.png" alt="picture" class="img-fluid" class="gmb">
      </picture>
    </div>


  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</body>

</html>