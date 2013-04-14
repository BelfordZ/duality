<?php
session_start();
require("db_query.php");

class Register
{
	private $username;
	private $password;
	private $firstName;
	private $lastName;
	private $address;
	private $postCode;
	private $city;
	private $country;
	private $company;
	private $phoneNum;

	private $hostName;
	private $path;
	
	function register()
	{
	}
	public function check_attempted()
	{
		if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName'])
				&& isset($_POST['lastName']) && isset($_POST['address']) && isset($_POST['postalCode'])
				&& isset($_POST['city']) && isset($_POST['country']) && isset($_POST['company']) && isset($_POST['phoneNumber']) )
		{
			$this->username = $_POST['username'];
			$this->password = $_POST['password'];

			$this->firstName = $_POST['firstName'];
			$_SESSION['NEW_NAME_FIRST'] = $this->firstName;
	
			$this->lastName = $_POST['lastName'];
			$_SESSION['NEW_NAME_LAST'] = $this->lastName;
			
			$this->address = $_POST['address'];
			$_SESSION['NEW_ADDRESS'] = $this->address;
			
			$this->postCode = $_POST['postalCode'];
			$_SESSION['NEW_POST_CODE'] = $this->postCode;
	
			$this->city = $_POST['city'];
			$_SESSION['NEW_CITY'] = $this->city;
	
			$this->country = $_POST['country'];
			$_SESSION['NEW_COUNTRY'] = $this->country;       		     
	
			$this->company = $_POST['company'];
			$_SESSION['NEW_COMPANY'] = $this->company;
	
			$this->phoneNum = $_POST['phoneNumber'];
			$_SESSION['NEW_PHONE'] = $this->phoneNum;
			
			return true;
		}
		else
		{
			return false;
		}
	}
	public function try_registration()
	{
		$dbq = new db_q();
		$usernameAvail = $dbq->db_q_register($this->username, $this->password, $this->firstName, $this->lastName, $this->address, $this->postCode,
				 		     $this->city, $this->country, $this->company, $this->company, $this->phoneNum);
		if ($usernameAvail)
		{
			$_SESSION['USER_NAME'] = $this->username;
			return true;
		}
		else
		{
			$_SESSION['USR_TAKEN'] = true;
		}
	}
}