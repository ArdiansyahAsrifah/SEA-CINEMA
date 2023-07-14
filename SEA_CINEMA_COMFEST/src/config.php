<?php 
 
$server = "localhost";
$user = "root";
$pass = "";
$database = "cinema";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    die("<script>alert('Gagal konek dengan database.')</script>");
}
 
?>