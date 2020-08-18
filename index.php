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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['textfield2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "menu.php";
  $MM_redirectLoginFailed = "index.php?textfield4=salah";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT namauser, password FROM `user` WHERE namauser=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Index</title>
</head>

<body topmargin="150">
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
<h1><center> Sistem Informasi Absensi Karyawan</center></h1>
<table width="488" height="201" border="6" align="center">
    <tr>
      <td width="473" height="136"><table width="304" border="0" align="center">
      <tr><td colspan="2" align="right"><h1> LOGIN</h1>
        <h1><center></h1></td>
        <td width="144"><img src="index.png" width="32" height="39" /></td></tr>
        <tr>
          <td width="135">Username</td>
          <td width="11">:</td>
          <td><label for="textfield2"></label>
            <input type="text" required="required" name="textfield" id="textfield2" placeholder="Masukkan Username"/></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td><label for="textfield3"></label>
            <input type="password" required="required" name="textfield2" id="textfield3" placeholder="Masukkan Password" /></td>
        </tr>
         <tr>
          <td colspan="3"><label for="textfield4" name="textfield4"></label>
        </tr>
      </table>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="Submit" id="button" style="background: #FFF" size="20" value="Login"/></td></tr>
  </table>
</form>
</body>
</html>