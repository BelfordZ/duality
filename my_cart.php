<?php
session_start();
require("cart.php");

$cart = new Cart();
$cart->add_items();
$contents = $cart->cart_contents();
?>