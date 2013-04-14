<?php
//sleep(1);
session_start();
echo("<a onclick=\"make_async('home.php', 'content')\">Home</a>");
echo("&nbsp&nbsp&nbsp");
if (isset($_SESSION['NAME_FIRST']))
{
	echo("<a onclick=\"make_async('form_order.php', 'content')\">Store</a>");
}
?>