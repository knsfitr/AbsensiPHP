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
  $insertSQL = sprintf("INSERT INTO `user` (namauser, password) VALUES (%s, %s)",
                       GetSQLValueString($_POST['namauser'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

$colname_regis = "-1";
if (isset($_GET['iduser'])) {
  $colname_regis = $_GET['iduser'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_regis = sprintf("SELECT * FROM `user` WHERE iduser = %s", GetSQLValueString($colname_regis, "int"));
$regis = mysql_query($query_regis, $koneksi) or die(mysql_error());
$row_regis = mysql_fetch_assoc($regis);
$totalRows_regis = mysql_num_rows($regis);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrasi Akun</title>
</head>

<body topmargin="150" bgcolor="#CCCCCC">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
    <center><table width="500" height="368" border="5" style="font: 'Trebuchet MS', Arial, Helvetica, sans-serif" bgcolor="#FFFFFF">
      <tr>
        <td><center>
          <h1>Registrasi</h1>
        </center>
  <table width="327" align="center">
    <tr valign="baseline">
      <td width="123" align="left" nowrap="nowrap">Nama User</td>
      <td width="192"><input type="text" name="namauser" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="76" align="left" nowrap="nowrap">Password</td>
      <td><input type="password" name="password" value="" size="32" /></td>
    </tr>
    <tr valign="baseline" align="center">
              <td colspan="2"><input type="submit" value="Registrasi" style="background: #FFF"/>
              <input type="reset" value="Batal" style="background: #FFF" />
              <a href="menu.php"><input type="button" name="button" id="button" value="Kembali" style="background: #FFF"/></a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($regis);
?>
