<?php
session_start();

session_register("clientId");

$myFile = "chat";
$newMsg = $_GET['textToSend'];

$refresh = $_GET['refresh'];
$myFile = $myFile . $_SESSION["clientId"];

if ($refresh)
{
  echo (file_get_contents($myFile, 50) . "\n");
  file_put_contents($myFile, "");
}
if (isset($newMsg))
{
    file_put_contents($myFile, $newMsg);
}

?>