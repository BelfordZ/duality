<html>
<head>
<link rel="stylesheet" type="text/css" href="http://localhost/~bawllz/look.css"/>								                                           
<script type="text/javascript" src="j_scripts.js"></script>
<?php
require("db_query.php");
//require("cart.php");
$dbq = new db_q();
$dbq->db_q_get_articles();
$results = $dbq->get_result();
$numOfResults = sizeof($results);
//$cart = new Cart();
?>
</head>
<body>
<select id="selMenu" onchange="order_fill_div('placeHolder')">
	<?php
	echo("<option>Select a Type</option>");
	for ($i=0; $i<$numOfResults; $i++)
	{
		echo("<option title=\"" . $results[$i]['cost'] . "\">" . $results[$i]['type'] . "</option>");
	}
	?>
</select>
<div id="placeHolder"></div>
</body>
