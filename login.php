<?php
/*	Class to handle login flow and authentication
**	
*/
require ("db_query.php");
class Login
{
	private $username;
	private $password;
	
	//opCode = 1 ->logged in
	//opCode = 2 ->not logged in, not attempted
	//opcode = 3 ->not logged in, attempt failed
	private $opCode;
	
	public function Login()
	{
		if (isset($_POST['username']) && isset($_POST['password']))
		{
			$this->username = $_POST['username'];
			$this->password = $_POST['password'];
			$this->authenticate();
		}
		else if (isset($_SESSION['NAME_FIRST']))
		{
			//return user is logged in
			$this->opCode = 1;
		}
		else
		{
			$this->opCode = 2;
		}
		
	}
	/*
	** Function which check mysql database for a username and password combo which was supplied via
	** 				post. Sets OpCode to the appropriate values after the query.
	*/
	private function authenticate()
	{
		$dbq = new db_q();
		$dbq->db_q_login($this->username, $this->password);
		$result = $dbq->get_result();
		
		//if login denied
		if ( $result == NULL )
		{
			$_SESSION['LOG_ATTEMPT'] += 1;
			$this->opCode=3;
		}
		//if login successful
		else
      {
			$_SESSION['NAME_FIRST'] = $result[0];
			setcookie('USER_NAME', $_POST['username'], time()+7*24*60*60);
			$this->opCode=1;
		}
	}
	/*
	**
	*/
	public function get_opcode()
	{
		return $this->opCode;	
	}
	/*
	**	Function which returns a string which is the last known attempted username, successful or not.
	** Usage: <input type="text" name="username" value="<?php get_username_default(); ?>" />
	*/
	public function get_username_default()
	{
		if (isset($_POST['username']))
		{
			return $_POST['username'];
		}
		if (isset($_COOKIE['USER_NAME']))
		{
			return $_COOKIE['USER_NAME'];
		}
		return;
	}
}


?>