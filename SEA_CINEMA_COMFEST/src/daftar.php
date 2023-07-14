<!DOCTYPE HTML>
<html>
    <head>
        <title>SEA CINEMA</title>
        <link rel="stylesheet" href="style_login.css">
    </head>
    <body>
        <div class="container">
          <h1>Daftar</h1>
            <form method="POST" action="cek_login.php">

                <input type="hidden" name="tujuan" value="DAFTAR">

                <label>Username</label>
                <br>
                <input name="username" type="text">
                <br>
				<label>Password</label>
                <br>
                <input name="password" type="password">
                <br>
                <label>Nama</label>
                <br>
                <input name="nama" type="text">
                <br>
                <label>Umur</label>
                <br>
                <input name="umur" type="text">
                <br>
                <button>Daftar</button>
                <p> Sudah punya akun?
                  <a href="Login.html">Login di sini</a>
                </p>
            </form>
        </div>
    </body>
</html>
