<?php
session_start();
require("db_query.php");

class Order_Form
{
	private $itemsName;
	private $itemsId;
	private $itemStock;
	private $costResult;

	function Order_Form($articleType, $aCost)
	{
		$dbq = new db_q();
		if (!$dbq)
		{
			echo("db connection could not be made");
		}

		$dbq->db_q_get_article_cost($articleType);
		$this->costResult = $dbq->get_result();

		$dbq->db_q_get_items($articleType);
		$tmpItemHolder = $dbq->get_result();

		$numOfItems = sizeof($tmpItemHolder);

		for ($i=0; $i<$numOfItems; $i++)
		{
			$this->itemsName[$i] = $tmpItemHolder[$i]['name'];
        		$this->itemsId[$i] = $tmpItemHolder[$i]['iid'];
        		$dbq->db_q_get_item_stock($this->itemsId[$i]);
        		$this->itemStock[$i] = $dbq->get_result();
		}
		$this->spit_html($articleType, $aCost);
	}
	private function spit_html($aType, $cost)
	{
		echo("<form>");
		$articleIndex = sizeof($this->itemsName);
		for ($i=0; $i<$articleIndex; $i++)
		{
			$colorIndex = sizeof($this->itemStock[$i]);
			echo(	"<div class=\"itemHolder\">
				    <div class=\"Name\">" . $this->itemsName[$i] . "</div>
				    <table class=\"articleData\">
				    <thead><th>Color</th><th>Small</th><th>Medium</th><th>Large</th><th>Xlarge</th></thead>");
			for ($j=0; $j<$colorIndex; $j++)
			{
				echo("<tr><td>" . $this->itemStock[$i][$j]['color']  . "</td>");
				for ($x=0; $x<4; $x++)
				{
					$szCode;
					switch ($x)
					{
						case 0:
							$szCode = "SM";
							$szStock = $this->itemStock[$i][$j]['s_stock'];
							break;
						case 1:
							$szCode = "MD";
							$szStock = $this->itemStock[$i][$j]['m_stock'];
							break;
						case 2:
							$szCode = "LG";
							$szStock = $this->itemStock[$i][$j]['l_stock'];
							break;
						case 3:
							$szCode = "XL";
							$szStock = $this->itemStock[$i][$j]['xl_stock'];
							break;
					}
					$stockClass;
					if ($szStock<10 && $szStock>0)
					{
						$stockClass = "low";
					}
					else if ($szStock>=10 && $szStock<20)
					{
						$stockClass = "mid";
					}
					else if ($szStock>=30)
					{
						$stockClass = "high";
					}
					else
					{
						$stockClass = "out";
					}
					$formId = $aType . "_" . $cost . "_" . $this->itemsName[$i] . "_" . $this->itemStock[$i][$j]['sid'] . "_" . $this->itemStock[$i][$j]['color'] . "_" . $szCode;
					echo("<td><input id=\"" . $formId . "\" class=\"" . $stockClass . "\" type=\"text\" onchange='add_changed(this)'/></td>");
				}
				echo("</tr>");
        	}
			echo("</tr></table></div>");
		}
		echo("<input type=\"button\" value=\"Add to Cart\" onclick='order_submission()'/></form>");
	}
}
$orderForm = new Order_Form($_GET["article"], $_GET['cost']);
?>
