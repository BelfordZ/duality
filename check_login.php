<?php
session_start();
require("db_query.php");

class check_login
{
	private $username;
	private $password;
	private	$hostName;
	private	$path;

	public function check_login()
	{
		$this->username = strip_tags($_POST['username']);
		$this->password = $_POST['password'];
		$this->hostName = $_SERVER["HTTP_HOST"];
		$this->path = rtrim(dirname($_SERVER["PHP_SELF"]), '/\\');
		$this->db_auth();
	}
	private function db_auth()
	{
		$dbq = new db_q();
		$dbq->db_q_login($this->username, $this->password);
		$result = $dbq->get_result();
		if ( $result == NULL )
		{
			$_SESSION['LOG_ATTEMPT'] += 1;
			$_SESSION['USER_NAME'] = $this->username;
			header("Location: http://$this->hostName$this->path/form_login.php");
		}
		else
      {
			$_SESSION['NAME_FIRST'] = $result[0];
			setcookie('USER_NAME', $_POST['username'], time()+7*24*60*60);
			header("Location: http://$this->hostName$this->path/true_login.php");
		}
	}
}
$chklog = new check_login;
?>