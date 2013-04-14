<?php
class db_wrap
{
	public $conn;
	
	public function db_connect()
	{
		$this->conn = mysql_connect('localhost', 'root');
		mysql_select_db('test', $this->conn);
		if (!$this->conn)
		{
			echo ("Connection to mysql db has failed");
			return false;
		}
		return $this->conn;
	}
}
?>