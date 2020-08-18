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
  $insertSQL = sprintf("INSERT INTO jabatan (kode_jabatan, id_karyawan, nama_jabatan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['kode_jabatan'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_jabatan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO jabatan (kode_jabatan, id_karyawan, nama_jabatan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['kode_jabatan'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_jabatan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_tampil_jabatan = "SELECT * FROM jabatan";
$tampil_jabatan = mysql_query($query_tampil_jabatan, $koneksi) or die(mysql_error());
$row_tampil_jabatan = mysql_fetch_assoc($tampil_jabatan);
$totalRows_tampil_jabatan = mysql_num_rows($tampil_jabatan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Data Jabatan</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color:#DCDCDC; font-family: Palatino Linotype"> 
<hr color="grey">
<div class="container">
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
<tr>
      <td><center><h1>Form Jabatan</h1></center></td>
      </tr>
    <tr>
      <td align="right"><a href="menu.php"><img src="kembali.png" width="40" height="40" />Kembali</a></td>
      </tr>
    <tr>
      <td><table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Kode Jabatan</td>
          <td><input type="text" name="kode_jabatan" value="" size="32" /></td>
          </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">ID Karyawan</td>
          <td><input type="text" name="id_karyawan" value="" size="32" maxlength="8" /></td>
          </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nama Jabatan</td>
          <td><select name="nama_jabatan">
            <option value="Manajer" <?php if (!(strcmp("Manajer", $row_tampil_jabatan['kode_jabatan']))) {echo "SELECTED";} ?>>Manajer</option>
            <option value="Kepala Bagian" <?php if (!(strcmp("Kepala Bagian", $row_tampil_jabatan['kode_jabatan']))) {echo "SELECTED";} ?>>Kepala Bagian</option>
            <option value="Staff" <?php if (!(strcmp("Staff", $row_tampil_jabatan['kode_jabatan']))) {echo "SELECTED";} ?>>Staff</option>
            </select></td>
          </tr>
        </table>
        </td>
        </tr>
<tr>
    <center><button type="submit" class="btn btn-primary" align="center">Submit</button>
  <input type="hidden" name="MM_insert" value="form1" />
 <button type="reset" class="btn btn-primary" align="center">Batal</button>
  <input type="hidden" name="MM_insert" value="form1" /></center>
</tr>
  <tr>
 <hr color="#CCCCCC" />
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form">
<center><h4> Detail Data Jabatan</h4></center>
  <tr>
    <table border="2" align="center">
      <tr>
        <td>Kode Jabatan</td>
        <td>ID Karyawan</td>
        <td>Nama Jabatan</td>
        <td>Aksi</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row_tampil_jabatan['kode_jabatan']; ?></td>
        <td><?php echo $row_tampil_jabatan['id_karyawan']; ?></td>
        <td><?php echo $row_tampil_jabatan['nama_jabatan']; ?></td>
        <td><a href="edit_jabatan.php?edit_jabatan=<?php echo $row_tampil_jabatan['kode_jabatan']; ?>"class="btn btn-info btn-lg"> <span class="glyphicon glyphicon-trash">Edit</span></a> <a href="delete_jabatan.php?hapus_jabatan=<?php echo $row_tampil_jabatan['kode_jabatan']; ?>"class="btn btn-info btn-lg"> <span class="glyphicon glyphicon-trash">Hapus</span></td>
      </tr>
      <?php } while ($row_tampil_jabatan = mysql_fetch_assoc($tampil_jabatan)); ?>
    </table>
  </tr>
</form>
</body>
</html>
<?php
mysql_free_result($tampil_jabatan);
?>
