<?php
// ambil pesan jika ada
if (isset($_GET["pesan"])) {
    $pesan = $_GET["pesan"];
}
// cek apakah form telah di submit
if (isset($_POST["submit"])) {
// form telah disubmit, proses data
// ambil nilai form
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));
// siapkan variabel untuk menampung pesan error
    $pesan_error="";
// cek apakah "username" sudah diisi atau tidak
    if (empty($username)) {

        $pesan_error .= "Username belum diisi <br>";
    }
// cek apakah "password" sudah diisi atau tidak
    if (empty($password)) {
        $pesan_error .= "Password belum diisi <br>";
    }
// buat koneksi ke mysql dari file connection.php
    include("connection.php");
// filter dengan mysqli_real_escape_string
    $username = mysqli_real_escape_string($link,$username);
    $password = mysqli_real_escape_string($link,$password);
// generate hashing
    $password_sha1 = sha1($password);
// cek apakah username dan password ada di tabel admin
    $query = "SELECT * FROM admin WHERE username = '$username'
AND password = '$password_sha1'";
    $result = mysqli_query($link,$query);
    if(mysqli_num_rows($result) == 0 ) {
// data tidak ditemukan, buat pesan error
        $pesan_error .= "Username dan/atau Password tidak sesuai";
    }
// bebaskan memory
    mysqli_free_result($result);
// tutup koneksi dengan database MySQL
    mysqli_close($link);
// jika lolos validasi, set session
    if ($pesan_error === "") {
        session_start();
        $_SESSION["nama"] = $username;
        header("Location: tampil_mahasiswa.php");
    }
}
else {
// form belum disubmit atau halaman ini tampil untuk pertama kali
// berikan nilai awal untuk semua isian form
    $pesan_error = "";
    $username = "";
    $password = "";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Sistem Informasi Mahasiswa</title>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang</h1>
        <h3>Sistem Informasi Kampusku</h3>

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
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                <div>
                    <label for="username">Username : </label>
                    <input type="text" name="username" id="username"
                           value="<?php echo $username ?>">
                </div>
                <div>
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password"
                           value="<?php echo $username ?>">
                </div>
                <div>
                    <button type="submit" name="submit">Login</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>