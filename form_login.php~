<?php
session_start();
require("login.php");

$login = new Login();
$opCode = $login->get_opcode();
switch ($opCode)
{
	case 1:
		{
			echo ("<h1>Welcome " . $_SESSION['NAME_FIRST'] . "</h1><br><input type=\"button\" value=\"Logout\" onClick=\"logout()\" />");
			break;
		}
	/*	fall through case 2, to group 2 & 3 due to similarity
	** case 2 -> not logged, no login attempted
	** case 3 -> not logged, failed attempt
	*/
	case 2:
	case 3:
		{
			echo("<form id=\"form_login\" action=\"\"><strong>Login</strong><br/>");
			if($opCode == 3)
			{
				echo("Invalid username or password<br/>");
			}
			echo("Username:<input name=\"username\" type=\"text\" id=\"username\" value=\"" . $login->get_username_default() . "\"/>");
			echo("<br/>Password:<input name=\"password\" type=\"text\" id=\"password\"/>");
			echo("<br/><input type=\"button\" value=\"Login\" onclick=\"login_attempt()\"/>");
			echo("<input type=\"button\" value=\"Register\" onclick=\"make_async('form_register.php', 'content')\"/>");
			echo("</form>");
			break;
		}
}
?>
