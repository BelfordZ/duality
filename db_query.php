<?php
//login is broken due to get_result() returning the full array instead of just [0]
require ("db_connect.php");
require ("misc_helpers.php");
class db_q
{

	private $query_str;
	private $q_result;
	private $dbWrapper;
	private $link;

	function db_q()
	{
		$this->dbWrapper = new db_wrap;
		$this->link = $this->dbWrapper->db_connect();
		if (!$this->link)
		{
			return false;
		}
	}
   public function get_result()
   {
		return $this->q_result;
   }
   public function db_q_login($username, $password)
   {
		$this->query_str = "SELECT name_first, name_last FROM CUSTOMER WHERE `username`='" . $username . "' AND `pword`='" . $password . "';";
		$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
		$this->q_result = mysql_fetch_array($this->q_result);
	}
	public function db_q_register($username, $password, $nameFirst, $nameLast, $addr, $pcode, $ct, $cntry, $cmpny, $phn)
	{
		$this->query_str ="INSERT INTO CUSTOMER (username, pword, name_first, name_last, address, postcode, city, country, company_name, phone)
								VALUES (" . "'" . $username . "', " . "'" . $password . "', " . "'" . $nameFirst . "', " . "'" . $nameLast . "', " 
								. "'" . $addr . "', " . "'" . $pcode . "', " . "'" . $ct . "', " . "'" . $cntry . "', " . "'" . $cmpny . "', " 
								. "'" . $phn . "');";
		$chkAvailUser = "SELECT * FROM CUSTOMER WHERE `username`='" . $username . "';";
		$chkAvailUser = mysql_query($chkAvailUser, $this->link) or die (mysql_error());
		$chkAvailUser = mysql_fetch_array($chkAvailUser);
		if (!isset($chkAvailUser[0]))
		{
			$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
			return true;
		}
		else
		{
			return false;
		}
	}
	public function db_q_get_article_cost($itemType)
	{
		$this->query_str = "SELECT ARTICLE.`cost` FROM `ARTICLE` WHERE ARTICLE.`type`='" . $itemType . "';";
		$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
		$this->q_result = mysql_fetch_array($this->q_result);
		$this->q_result = $this->q_result[0];
	}
	public function db_q_get_items($itemType)
	{
		$this->query_str = "SELECT ITEM.`iid`, ITEM.`name` FROM `ITEM` WHERE ITEM.`type`='" . $itemType . "';";
		$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
		$i = 0;
		$items;
		while($row = mysql_fetch_array($this->q_result))
		{
			$items[$i]['iid'] = $row['iid'];
			$items[$i]['name'] = $row['name'];
			$i++;
		}
		$this->q_result = $items;
	}
	public function db_q_get_item_stock($itemId)
	{	
		$itemId = int_to_char($itemId);
		$this->query_str = "SELECT STOCK.`sid`, STOCK.`colour`, STOCK.`l_stock`, STOCK.`m_stock`, STOCK.`s_stock`, STOCK.`xl_stock` FROM `STOCK` WHERE STOCK.`iid`='" . $itemId . "' ORDER BY STOCK.colour;";
		$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
		$stock;
		$i=0;
		while($row = mysql_fetch_array($this->q_result))
		{	
			$stock[$i]['color'] = $row['colour'];
			$stock[$i]['s_stock'] = $row['s_stock'];
			$stock[$i]['m_stock'] = $row['m_stock'];
			$stock[$i]['l_stock'] = $row['l_stock'];
			$stock[$i]['xl_stock'] = $row['xl_stock'];
			$stock[$i]['sid'] = $row['sid'];
			$i++;
		}
		$this->q_result = $stock;
	}
	public function db_q_get_articles()
	{
		$this->query_str = "SELECT ARTICLE.`type`, ARTICLE.`cost` FROM ARTICLE;";
		$this->q_result = mysql_query($this->query_str, $this->link) or die (mysql_error());
		$i=0;
		$tmpResult;
		while($row = mysql_fetch_array($this->q_result))
		{
			$tmpResult[$i]['type'] = $row['type'];
			$tmpResult[$i]['cost'] = $row['cost'];
			$i++;
		}
		$this->q_result = $tmpResult;
	}
}
?>