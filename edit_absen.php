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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE absensi SET id_karyawan=%s, tanggal=%s, jam_masuk=%s, jam_keluar=%s WHERE kode_absensi=%s",
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"),
                       GetSQLValueString($_POST['kode_absensi'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "tampil_absensi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE absensi SET id_karyawan=%s, tanggal=%s, jam_masuk=%s, jam_keluar=%s WHERE kode_absensi=%s",
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"),
                       GetSQLValueString($_POST['kode_absensi'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "tampil_absensi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE absensi SET id_karyawan=%s, tanggal=%s, jam_masuk=%s, jam_keluar=%s WHERE kode_absensi=%s",
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['jam_masuk'], "text"),
                       GetSQLValueString($_POST['jam_keluar'], "text"),
                       GetSQLValueString($_POST['kode_absensi'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "tampil_absensi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_absen = "-1";
if (isset($_GET['edit_absen'])) {
  $colname_edit_absen = $_GET['edit_absen'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_absen = sprintf("SELECT * FROM absensi WHERE kode_absensi = %s", GetSQLValueString($colname_edit_absen, "text"));
$edit_absen = mysql_query($query_edit_absen, $koneksi) or die(mysql_error());
$row_edit_absen = mysql_fetch_assoc($edit_absen);
$totalRows_edit_absen = mysql_num_rows($edit_absen);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Data Absensi</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color:#DCDCDC; font-family: Palatino Linotype">
<H1 align="center">Form Absensi</H1>
<tr>
      <td align="left"><a href="tampil_absensi.php"><img src="kembali.png" width="40" height="40" />Kembali</a></td>
</tr>
<div class="container">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td width="95" align="left" nowrap="nowrap">Kode Absensi</td>
      <td width="279"><input type="text" name="kode_absensi" value="<?php echo $row_edit_absen['kode_absensi']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">ID Karyawan</td>
      <td><input type="text" name="id_karyawan" value="<?php echo htmlentities($row_edit_absen['id_karyawan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tanggal</td>
      <td><input type="text" name="tanggal" value="<?php echo htmlentities($row_edit_absen['tanggal'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Jam</td>
      <td valign="baseline"><table>
      <tr>
      <td>Jam Masuk</td>
      </tr>
        <tr>
          <td><input type="radio" name="jam_masuk" value="07:30 WIB" <?php if (!(strcmp(htmlentities($row_edit_absen['jam_masuk'], ENT_COMPAT, 'utf-8'),"07:30 WIB"))) {echo "checked=\"checked\"";} ?> />
            07:30 WIB</td>
        </tr>
        <tr>
          <td><input type="radio" name="jam_masuk" value="10:00 WIB" <?php if (!(strcmp(htmlentities($row_edit_absen['jam_masuk'], ENT_COMPAT, 'utf-8'),"10:00 WIB"))) {echo "checked=\"checked\"";} ?> />
            10:00 WIB</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td valign="baseline"><table>
      <tr>
      <td> Jam Keluar</td>
      </tr>
        <tr>
          <td><input type="radio" name="jam_keluar" value="15:30 WIB" <?php if (!(strcmp(htmlentities($row_edit_absen['jam_keluar'], ENT_COMPAT, 'utf-8'),"15:30 WIB"))) {echo "checked=\"checked\"";} ?> />
            15:30 WIB</td>
        </tr>
        <tr>
          <td><input type="radio" name="jam_keluar" value="18:00 WIB" <?php if (!(strcmp(htmlentities($row_edit_absen['jam_keluar'], ENT_COMPAT, 'utf-8'),"18:00 WIB"))) {echo "checked=\"checked\"";} ?> />
            18:00 WIB</td>
        </tr>
      </table></td>
    </tr>
    <tr>
     <td colspan="2"><center><input type="submit" value="Update" class="btn btn-primary" align="center" style="background-color:#FFF"/></td>
  </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode_absensi" value="<?php echo $row_edit_absen['kode_absensi']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_absen);
?>
