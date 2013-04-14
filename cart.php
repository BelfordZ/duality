<?php
session_start();
require("misc_helpers.php");

class Cart_Item
{
	$Article;
	$itemName;
	$itemSid;
	$itemSz;
	$itemCol;
	$itemQuant;
	public function Order_Item($article, $aCost $itemArr)
	{
		$this->Article = $article;
		$this->itemName = $itemArr['name'];
		$this->itemSid = $itemArr['sid'];
		$this->itemSz = $itemArr['color'];
		$this->itemCol = $itemArr['sz'];
		$this->itemQuant = $itemArr['quant'];
	}

}
class Cart
{
	private $Order;
	
	private $numPosted	;
	private $articleType;
	private $articleCost;
	private $name;
	private $sid;
	private $color;
	private $sz;
	private $quantity;
	private $articleTotal;
	private $total;
	
	public function Cart()
	{
		if (isset($_POST["num"]))
		{
			$this->add_items();
		}
	}
	
	private function add_items()
	{
		//this function should just pass the posted data into a cookie.
		/* this code should go into the check-cart function
		* push this processing to the client
		* on checkout, should revalidate the data from database
		
		$this->numPosted = urldecode($_POST['num']);
		$this->articleType = urldecode($_POST['article']);
		$this->articleCost = $_POST['cost'];
		for ($i=0; $i<numPosted; i++)
		{
			$items = explode("!", $_POST[int_to_char($i)]);
			
			$item
			$tmp = explode("#", $items[0]);
			$item['name'] = $tmp[1];
			
			$tmp = explode("#", $items[1]);
			$item['sid'] = $tmp[1];
			
			$tmp = explode("#", $items[2]);
			$item['color'] = $tmp[1];
						
			$tmp = explode("#", $items[3]);
			$item['sz'] = $tmp[1];
			
			$tmp = explode("#", $items[4]);
			$item['quant'] = $tmp[1];			
			
			$this->Order[i] = new Cart_Item($this->articleType, $this->articleCost, $item);
			
			$_SESSION['CART'][$this->articleType][$this->
			*/

		}
	}
	public function cart_contents()
	{
		
	}
}

?>