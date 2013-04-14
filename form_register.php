<?php
session_start();
require ("register.php");
$reg = new Register();
if ($reg->check_attempted())
{
	if ($reg->try_registration())
	{
		setcookie('USER_NAME', $_POST['username'], time()*7*24*60*60);
		echo("Registration Success");
	}
	else
	{	
	}	
}
else
{
	echo("<form name=\"form_register\" action=\"\"><h1>Registration</h1><br>");
	if ($_GET['USR_TAKEN']==true)
	{ 
		echo("User name in use, please choose another<br>");
	}
	echo("Username:<input name=\"username\" type=\"text\" id=\"username\" value=\"" . @$_SESSION['NEW_USER_NAME'] . "\"/>");
	echo("<br>Password:<input name=\"password\" type=\"text\" id=\"password\" value=\"" . @$_SESSION['NEW_PASSWORD'] . "\"/>");
	echo("<br>First Name:<input name=\"firstName\" type=\"text\" id=\"firstName\" value=\"" . @$_SESSION['NEW_NAME_FIRST'] . "\"/>");
	echo("<br>Last Name:<input name=\"lastName\" type=\"text\" id=\"lastName\" value=\"" . @$_SESSION['NEW_NAME_LAST'] . "\"/>");
	echo("<br>Address:<input name=\"address\" type=\"text\" id=\"address\" value=\"" . @$_SESSION['NEW_ADDRESS'] . "\"/>");
	echo("<br>Postal Code:<input name=\"postalCode\" type=\"text\" id=\"postalCode\" value=\"" . @$_SESSION['NEW_POST_CODE'] . "\"/>");
	echo("<br>City:<input name=\"city\" type=\"text\" id=\"city\" value=\"" . @$_SESSION['NEW_CITY'] . "\"/>");
	echo("<br>Country:<input name=\"country\" type=\"text\" id=\"country\" value=\"" . @$_SESSION['NEW_COUNTRY'] . "\"/>");
	echo("<br>Company:<input name=\"company\" type=\"text\" id=\"company\" value=\"" . @$_SESSION['NEW_COMPANY'] . "\"/>");
	echo("<br>Phone Number:<input name=\"phoneNumber\" type=\"text\" id=\"phoneNumber\" value=\"" . @$_SESSION['NEW_PHONE'] . "\"/>");
	echo("<br><input type=\"button\" name=\"submit\" value=\"register\" onclick=\"register_attempt()\"/></form>");
}
?>