<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_laporan = "-1";
if (isset($_GET['kode_absensi'])) {
  $colname_laporan = $_GET['kode_absensi'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_laporan = sprintf("SELECT * FROM absensi WHERE kode_absensi = %s", GetSQLValueString($colname_laporan, "text"));
$laporan = mysql_query($query_laporan, $koneksi) or die(mysql_error());
$row_laporan = mysql_fetch_assoc($laporan);
$totalRows_laporan = mysql_num_rows($laporan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="2">
  <tr>
    <td>kode_absensi</td>
    <td>id_karyawan</td>
    <td>jenis_absensi</td>
    <td>tanggal</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_laporan['kode_absensi']; ?></td>
      <td><?php echo $row_laporan['id_karyawan']; ?></td>
      <td><?php echo $row_laporan['jenis_absensi']; ?></td>
      <td><?php echo $row_laporan['tanggal']; ?></td>
    </tr>
    <?php } while ($row_laporan = mysql_fetch_assoc($laporan)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($laporan);
?>
