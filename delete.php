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

if ((isset($_GET['hapus'])) && ($_GET['hapus'] != "")) {
  $deleteSQL = sprintf("DELETE FROM karyawan WHERE id_karyawan=%s",
                       GetSQLValueString($_GET['hapus'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());

  $deleteGoTo = "tampil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_hapus = "-1";
if (isset($_GET['hapus'])) {
  $colname_hapus = $_GET['hapus'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_hapus = sprintf("SELECT * FROM karyawan WHERE id_karyawan = %s", GetSQLValueString($colname_hapus, "int"));
$hapus = mysql_query($query_hapus, $koneksi) or die(mysql_error());
$row_hapus = mysql_fetch_assoc($hapus);
$totalRows_hapus = mysql_num_rows($hapus);$colname_hapus = "-1";
if (isset($_GET['hapus'])) {
  $colname_hapus = $_GET['hapus'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_hapus = sprintf("SELECT * FROM karyawan WHERE id_karyawan = %s", GetSQLValueString($colname_hapus, "int"));
$hapus = mysql_query($query_hapus, $koneksi) or die(mysql_error());
$row_hapus = mysql_fetch_assoc($hapus);
$totalRows_hapus = mysql_num_rows($hapus);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($hapus);
?>
