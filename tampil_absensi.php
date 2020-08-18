<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO absensi (kode_absensi, id_karyawan, tanggal, jam_masuk, jam_keluar) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_absensi'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO absensi (kode_absensi, id_karyawan, tanggal, jam_masuk, jam_keluar) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_absensi'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO absensi (kode_absensi, id_karyawan, tanggal, jam_masuk, jam_keluar) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_absensi'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_absensi = "SELECT * FROM absensi";
$tampil_absensi = mysql_query($query_tampil_absensi, $koneksi) or die(mysql_error());
$row_tampil_absensi = mysql_fetch_assoc($tampil_absensi);
$totalRows_tampil_absensi = mysql_num_rows($tampil_absensi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Absensi</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color:#DCDCDC; font-family: Palatino Linotype"> 
<div class="container">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<h1><center>Form Absensi</center></h1></td>
    </tr>

  <tr height="18">
      <td height="38" align="right"><a href="menu.php"><img src="kembali.png" width="40" height="40" />Kembali</a></td>
    </tr>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center">
    <tr valign="baseline">
      <td width="93" align="left" nowrap="nowrap">Kode Absensi</td>
      <td width="281"><input type="text" name="kode_absensi" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">ID Karyawan</td>
      <td><input type="text" name="id_karyawan" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tanggal</td>
      <td><input type="date" name="tanggal" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="84" align="left" nowrap="nowrap">Jam</td>
      <td valign="baseline"><table>
      <tr>
      <td> Jam Masuk </td>
        <tr>
          <td><input type="radio" name="jam_masuk" value="07:30 WIB" />
            07:30 WIB</td>
        </tr>
        <tr>
          <td><input type="radio" name="jam_masuk" value="10:00 WIB" />
            10:00 WIB</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td height="144" align="right" nowrap="nowrap">&nbsp;</td>
      <td valign="baseline"><table>
      <tr>
      <td> Jam Keluar</td>
        <tr>
          <td><input type="radio" name="jam_keluar" value="15:30 WIB" />
            15:30 WIB</td>
        </tr>
        <tr>
          <td><input type="radio" name="jam_keluar" value="18:00 WIB" />
            18:00 WIB</td>
        </tr>
      </table>
      <center><button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="MM_insert" value="form2" />
       <button type="reset" class="btn btn-primary">Batal</button></center>
                <input type="hidden" name="MM_insert" value="form2" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<table border="2" align="center">
  <tr>
    <td>Kode Absensi</td>
    <td>ID Karyawan</td>
    <td>Tanggal</td>
    <td>Jam Masuk</td>
    <td>Jam Keluar</td>
    <td>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_tampil_absensi['kode_absensi']; ?></td>
      <td><?php echo $row_tampil_absensi['id_karyawan']; ?></td>
      <td><?php echo $row_tampil_absensi['tanggal']; ?></td>
      <td><?php echo $row_tampil_absensi['jam_masuk']; ?></td>
      <td><?php echo $row_tampil_absensi['jam_keluar']; ?></td>
      <td> <a href="edit_absen.php?edit_absen=<?php echo $row_tampil_absensi['kode_absensi']; ?>"class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-trash">Edit</span></a> <a href="delete_absen.php?hapus_absen=<?php echo $row_tampil_absensi['kode_absensi']; ?>"class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-trash">Hapus</span></a></td>
    </tr>
    <?php } while ($row_tampil_absensi = mysql_fetch_assoc($tampil_absensi)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($tampil_absensi);
?>
