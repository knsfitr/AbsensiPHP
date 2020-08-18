 <?php
$host="localhost";
$username="root";
$password="";
$namadatabase="absensikaryawan";
$connection=mysql_connect($host, $username, $password) or die("Kesalahan Koneksi...!!");
mysql_select_db($namadatabase, $connection) or die("Database Gagal terkoneksi");
?>