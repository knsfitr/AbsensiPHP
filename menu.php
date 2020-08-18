<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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
<!DOCTYPE html>
<html>
<head>
	<title>Menu Utama</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>	
<body bgcolor="#696969" style="font-family:Tahoma, Geneva, sans-serif"><font color="#FFFFFF">
<form name="form1" method="post" action="">
  <table width="1340" height="504" border="0">
    <tr>
      <td height="30"><h2>SELAMAT DATANG</h2>
      <td align="right" style=" font-size:9px font-family:Tahoma, Geneva, sans-serif"><p><i> 
<?php
date_default_timezone_set('Asia/Jakarta');
echo date('d-m-Y H:i:s');
?>
</td>
    </tr>
    <tr height="18">
      <td width="658" height="43" bgcolor="#696969"><ul id="MenuBar2" class="MenuBarHorizontal">
        <li><b><a class="MenuBarItemSubmenu" style="background-color:#696969"><font color="#FFFFFF">Karyawan</a>
          <ul>
            <li><a href="tampil.php" style="background-color:#696969"><font color="#FFFFFF">Data Karyawan</a></li>
            <li><a href="tampil_jabatan.php" style="background-color:#696969"><font color="#FFFFFF">Data Jabatan</a></li>
</ul>
        </li>
        <li><a href="tampil_absensi.php" style="background-color:#696969"><font color="#FFFFFF">Absensi</a></li>
       
</ul>
        </li>
</ul></td>
      <td width="672" align="right" bgcolor="#696969"> <table width="506" border="0">
        <tr align="center">
         <td width="162" height="37"><a href="menu.php"><img src="home.png" width="27" height="26"></a><br>
<b><font size="2"><font color="#FFFFFF">Home</center></td>
<td width="166" height="37"><a href="regis.php"><img src="regis.png" width="27" height="26"></a><br>
<b><font size="2"><font color="#FFFFFF">Register</center></td>
          <td width="164"><a href="index.php"><img src="cancel.png" width="27" height="26"><br>
<b><font size="2"><font color="#FFFFFF">Keluar</center></td>
        </tr>
      </table>
    </tr>
    <tr>
      <td height="379" colspan="2" bgcolor=	"#696969"><p><img src="menu.png" width="1348" height="371"><b>      </b></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
  </script>
</body>
</html>