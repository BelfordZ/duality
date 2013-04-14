<?php
session_start();

//delete potentially existant cookies
setcookie ("username", "", time() - 3600);
setcookie ("password", "", time() - 3600);

//end the session
setcookie (session_name(), "", time() - 3600);
$_SESSION['NAME_FIRST'] = "";
session_destroy();
header("location: form_login.php");
?>