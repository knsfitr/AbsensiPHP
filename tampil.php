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
  $insertSQL = sprintf("INSERT INTO karyawan (id_karyawan, nama_karyawan, alamat, no_telepon, jenis_kelamin) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_karyawan'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telepon'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO karyawan (id_karyawan, nama_karyawan, alamat, no_telepon, jenis_kelamin) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_karyawan'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telepon'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_tampil = "SELECT * FROM karyawan";
$tampil = mysql_query($query_tampil, $koneksi) or die(mysql_error());
$row_tampil = mysql_fetch_assoc($tampil);
$totalRows_tampil = mysql_num_rows($tampil);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Data Karyawan</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color:#DCDCDC; font-family: Palatino Linotype"> 
<div class="container">
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
<h1><center>Form Karyawan</center></h1></td>
    </tr>

    <tr height="18">
      <td height="38" align="right"><a href="menu.php"><img src="kembali.png" width="40" height="40" />Kembali</a></td>
    </tr>
    <tr>
      <td height="325" colspan="2"><table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">ID Karyawan&nbsp; &nbsp; &nbsp;</td>
          <td><input type="text" name="id_karyawan" value="" size="32" maxlength="8" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nama Karyawan&nbsp; &nbsp; &nbsp;</td>
          <td><input type="text" name="nama_karyawan" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Alamat&nbsp; &nbsp; &nbsp;</td>
          <td><input type="text" name="alamat" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">No Telepon&nbsp; &nbsp; &nbsp;</td>
          <td><input type="text" name="no_telepon" value="" size="32" maxlength="13"/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Jenis Absensi&nbsp; &nbsp; &nbsp;</td>
          <td valign="baseline"><table>
            <tr>
              <td><input type="radio" name="jenis_kelamin" value="Laki-Laki" />
                Laki-Laki</td>
            </tr>
            <tr>
              <td><input type="radio" name="jenis_kelamin" value="Perempuan" />
                Perempuan</td>
            </tr>
                 <tr>

          </table></td>
        </tr>
      </table>
       <p></p>
        <p></p>
      <center><button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="MM_insert" value="form2" />
       <button type="reset" class="btn btn-primary">Batal</button></center>
                <input type="hidden" name="MM_insert" value="form2" />
              </p>
    </tr>
  </table>
</form>
<hr color="grey">
<p><h3 align="center">Detail Data Karyawan</h3></p>
<table border="2" align="center">
  <tr>
    <td align="center"><b>ID Karyawan</td>
    <td align="center"><b>Nama Karyawan</td>
    <td align="center"><b>Alamat</td>
    <td align="center"><b>No Telepon</td>
    <td align="center"><b>Jenis Kelamin</td>
    <td align="center"><b>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_tampil['id_karyawan']; ?></td>
      <td><?php echo $row_tampil['nama_karyawan']; ?></td>
      <td><?php echo $row_tampil['alamat']; ?></td>
      <td><?php echo $row_tampil['no_telepon']; ?></td>
      <td><?php echo $row_tampil['jenis_kelamin']; ?></td>
      <td>
        <a href="edit.php?edit=<?php echo $row_tampil['id_karyawan']; ?>" class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-trash">Edit</span></a>
<a href="delete.php?hapus=<?php echo $row_tampil['id_karyawan']; ?>" class="btn btn-info btn-lg">
  <span class="glyphicon glyphicon-trash">Hapus</span></a>
    </tr>
    <?php } while ($row_tampil = mysql_fetch_assoc($tampil)); ?>
</table>
<script src="js/jquery.min.js"></script>
<script src="js/boostrap.min.js"></script>
<p>&nbsp;</p>
<p></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</td>
</tr>
</body>
</html>
<?php
mysql_free_result($tampil);
?>
