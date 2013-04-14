<?php
session_start();
$hostName = $_SERVER["HTTP_HOST"];
$path = rtrim(dirname($_SERVER["PHP_SELF"]), '/\\');
?>
<?php
if (isset($_SESSION['NAME_FIRST']))
{
	echo ("<h1>Welcome " . $_SESSION['NAME_FIRST'] . "</h1>");
}
else
{
	header("Location: http://$hostName$path/form_login.php");
}
?>
<br>
<input type="button" value="Logout" onClick="mk_async('loginWrap', '/logout.php')" />